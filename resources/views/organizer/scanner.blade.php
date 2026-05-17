@extends('layouts.dashboard')

@section('content')
    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    <div class="space-y-10">

        <!-- HEADER -->
        <div>

            <h1 class="text-5xl font-black">
                QR Check-in Scanner
            </h1>

            <p class="text-slate-400 mt-3">
                Scan atau upload QR ticket peserta untuk validasi check-in event.
            </p>

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

            <!-- SCANNER -->
            <div class="glass rounded-[32px] p-8">

                <!-- CAMERA -->
                <div id="reader" class="overflow-hidden rounded-3xl mb-6">
                </div>

                <!-- UPLOAD -->
                <label class="block">

                    <input type="file" id="qrUpload" accept="image/*" class="hidden">

                    <div
                        class="cursor-pointer rounded-3xl border border-dashed border-violet-500/40 bg-violet-500/10 p-6 text-center hover:bg-violet-500/20 transition">

                        <h2 class="text-xl font-black text-violet-300">
                            Upload QR Image
                        </h2>

                        <p class="text-slate-400 mt-2">
                            Upload screenshot atau foto QR
                        </p>

                    </div>

                </label>

            </div>

            <!-- RESULT -->
            <div class="glass rounded-[32px] p-8">

                <h2 class="text-3xl font-black mb-8">
                    Scan Result
                </h2>

                <div id="resultBox"
                    class="rounded-3xl border border-dashed border-white/10 p-10 text-center min-h-[350px] flex flex-col items-center justify-center">

                    <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center mb-6">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4" />

                        </svg>

                    </div>

                    <h2 class="text-4xl font-black">
                        Waiting Scan...
                    </h2>

                    <p class="text-slate-400 mt-4">
                        Arahkan kamera ke QR Ticket
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- QR LIB -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
const resultBox = document.getElementById('resultBox');

let isProcessing  = false;
let lastScannedCode = '';
let lastScannedTime = 0;

/*
|--------------------------------------------------------------------------
| SUCCESS VIEW
|--------------------------------------------------------------------------
*/
function successView(data) {
    resultBox.innerHTML = `
        <div class="w-28 h-28 rounded-full bg-emerald-500/20 flex items-center justify-center mb-8 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="text-5xl font-black text-emerald-400">CHECK-IN SUCCESS</h2>
        <p class="mt-6 text-2xl font-bold">${data.user}</p>
        <p class="text-slate-400 mt-2">${data.event}</p>
    `;
}

/*
|--------------------------------------------------------------------------
| FAILED VIEW
|--------------------------------------------------------------------------
*/
function failedView(message) {
    resultBox.innerHTML = `
        <div class="w-28 h-28 rounded-full bg-red-500/20 flex items-center justify-center mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <h2 class="text-5xl font-black text-red-400">VALIDATION FAILED</h2>
        <p class="mt-6 text-xl text-slate-300">${message}</p>
    `;
}

/*
|--------------------------------------------------------------------------
| PROCESS QR
|--------------------------------------------------------------------------
*/
async function processQRCode(decodedText) {

    const now = Date.now();

    if (decodedText === lastScannedCode && (now - lastScannedTime) < 10000) return;
    if (isProcessing) return;

    isProcessing    = true;
    lastScannedCode = decodedText;
    lastScannedTime = now;

    let ticketCode = decodedText;

    if (decodedText.includes('/tickets/')) {
        ticketCode = decodedText.split('/tickets/')[1];
    }

    // Ambil CSRF dari cookie Laravel (tidak perlu meta tag)
    const csrfToken = '{{ csrf_token() }}';

    try {
        const response = await fetch('/organizer/checkin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ ticket_code: ticketCode })
        });

        const data = await response.json();

        if (data.success) {
            successView(data);
        } else {
            failedView(data.message);
        }

    } catch (error) {
        failedView('Gagal terhubung ke server');
    }

    setTimeout(() => { isProcessing = false; }, 5000);
}

/*
|--------------------------------------------------------------------------
| CAMERA SCAN
|--------------------------------------------------------------------------
*/
const html5QrCode = new Html5Qrcode("reader");

html5QrCode.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 280 },
    async (decodedText) => { processQRCode(decodedText); }
);

/*
|--------------------------------------------------------------------------
| IMAGE UPLOAD SCAN
|--------------------------------------------------------------------------
*/
document.getElementById('qrUpload').addEventListener('change', async function(event) {
    const file = event.target.files[0];
    if (!file) return;
    try {
        const result = await html5QrCode.scanFile(file, true);
        processQRCode(result);
    } catch (error) {
        failedView('QR tidak terbaca');
    }
});
</script>

@endsection
