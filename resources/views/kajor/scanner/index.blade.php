@extends('kajor.layouts.app')

@section('title', 'Scan QR Code - ' . $jorongName)

@section('head')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<style>
    .scanner-container {
        max-width: 500px;
        margin: 0 auto;
    }
    .scanner-box {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
    }
    #reader {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        background: #000;
    }
    #reader video {
        border-radius: 12px;
    }
    .result-box {
        margin-top: 1.5rem;
        padding: 1rem;
        border-radius: 12px;
        display: none;
    }
    .result-success {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
    }
    .result-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }
    .result-info {
        background: rgba(99, 102, 241, 0.15);
        border: 1px solid rgba(99, 102, 241, 0.3);
        color: #6366f1;
    }
    .btn-scan {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 1rem;
    }
    .btn-scan:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    .scan-status {
        margin-top: 1rem;
        color: #666;
        font-size: 0.9rem;
    }
    .instruction {
        background: rgba(0,0,0,0.02);
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        text-align: left;
    }
    .instruction ul {
        margin: 0.5rem 0 0 1.5rem;
        color: #666;
    }
    .instruction li {
        margin-bottom: 0.5rem;
    }
    .camera-error {
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .camera-error i {
        font-size: 2rem;
        color: #f59e0b;
        margin-bottom: 0.5rem;
        display: block;
    }
    .camera-error h4 {
        margin: 0 0 0.5rem 0;
        color: #f59e0b;
    }
    .camera-error p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }
    .camera-error ol {
        text-align: left;
        margin: 1rem 0 0 1.5rem;
        color: #666;
        font-size: 0.9rem;
    }
    .camera-error ol li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('konten')
<div style="margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0.5rem;">Scan QR Code</h2>
    <p style="color: #999;">Jorong: <strong>{{ ucwords(strtolower($jorongName)) }}</strong></p>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="scanner-container">
        <div class="scanner-box">
            <div id="cameraError" class="camera-error" style="display: none;">
                <i class="ri-camera-off-line"></i>
                <h4>Kamera Tidak Aktif</h4>
                <p>Izinkan akses kamera untuk melakukan scan QR Code</p>
                <ol>
                    <li>Klik ikon <strong>Kunci/Lock</strong> di address bar browser</li>
                    <li>Pilih <strong>Allow/Centang "Camera"</strong></li>
                    <li>Refresh halaman ini</li>
                    <li>Atau klik tombol "Mulai Scan" dan izinkan saat muncul popup</li>
                </ol>
            </div>

            <div class="instruction">
                <strong>Cara Scan:</strong>
                <ul>
                    <li>Pastikan kamera diizinkan (Allow) saat diminta</li>
                    <li>Arahkan kamera ke QR Code</li>
                    <li>Tunggu hingga QR terdeteksi</li>
                    <li>Data keluarga akan otomatis ditampilkan</li>
                </ul>
            </div>

            <div id="reader"></div>

            <div class="scan-status" id="scanStatus">
                <i class="ri-camera-line"></i> Klik tombol "Mulai Scan" untuk memulai
            </div>

            <button class="btn-scan" id="startScan" onclick="startScanner()">
                <i class="ri-qr-scan-line"></i> Mulai Scan
            </button>
            <button class="btn-scan" id="stopScan" onclick="stopScanner()" style="display: none; background: #ef4444;">
                <i class="ri-close-line"></i> Berhenti
            </button>

            <div class="result-box" id="resultBox"></div>
        </div>
    </div>
</div>

<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('startScan').style.display = 'none';
        document.getElementById('stopScan').style.display = 'inline-flex';
        document.getElementById('scanStatus').innerHTML = '<i class="ri-loader-line animate-spin"></i> Memindai...';

        html5QrcodeScanner = new Html5Qrcode("reader");

        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            onScanFailure
        ).catch(err => {
            console.error("Camera error:", err);
            
            let errorMessage = 'Error: ' + err.message;
            
            if (err.message.includes('Permission') || err.message.includes('NotAllowedError') || err.message.includes('Permission denied')) {
                errorMessage = 'Error: Permission denied - Kamera tidak diizinkan. Silakan izinkan akses kamera di pengaturan browser.';
                document.getElementById('cameraError').style.display = 'block';
                document.getElementById('reader').style.display = 'none';
            } else if (err.message.includes('NotFoundError') || err.message.includes('no cameras')) {
                errorMessage = 'Error: Kamera tidak ditemukan. Pastikan perangkat memiliki kamera.';
            }
            
            document.getElementById('scanStatus').innerHTML = '<span style="color: #ef4444;">' + errorMessage + '</span>';
            resetButtons();
        });
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                resetButtons();
                document.getElementById('scanStatus').innerHTML = 'Scanner dihentikan';
            }).catch(err => {
                console.log(err);
                resetButtons();
            });
        }
    }

    function resetButtons() {
        document.getElementById('startScan').style.display = 'inline-flex';
        document.getElementById('stopScan').style.display = 'none';
    }

    function onScanSuccess(decodedText, decodedResult) {
        stopScanner();
        document.getElementById('scanStatus').innerHTML = 'QR terdeteksi! Memproses...';

        processQRCode(decodedText);
    }

    function onScanFailure(error) {
        // Silent fail - terus scanning
    }

    function processQRCode(qrText) {
        const resultBox = document.getElementById('resultBox');
        resultBox.style.display = 'block';
        resultBox.className = 'result-box result-info';
        resultBox.innerHTML = '<i class="ri-loader-line animate-spin"></i> Memproses QR Code...';

        // Extract URL from QR code
        let url = qrText;
        if (!url.startsWith('http')) {
            // If just the token
            url = '{{ url("/") }}' + qrText;
        }

        // Parse the URL to extract keluarga_id and token
        try {
            const urlObj = new URL(url);
            const pathParts = urlObj.pathname.split('/');
            
            // Find keluarga_id in path
            let keluargaId = null;
            let token = null;

            // Check path like /petugas-pendataan-keluarga/{id}/edit?token={token}
            const editIndex = pathParts.findIndex(p => p === 'edit');
            if (editIndex > 0) {
                keluargaId = pathParts[editIndex - 1];
            }

            // Get token from query
            token = urlObj.searchParams.get('token');

            if (!keluargaId || !token) {
                throw new Error('Format QR tidak valid');
            }

            // Send to server to verify
            fetch('{{ route("kajor.qr.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    keluarga_id: keluargaId,
                    token: token
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultBox.className = 'result-box result-success';
                    resultBox.innerHTML = `
                        <i class="ri-check-line"></i> ${data.message}
                        <br><br>
                        <a href="${data.redirect_url}" class="btn-scan" style="display: inline-block; text-decoration: none;">
                            <i class="ri-eye-line"></i> Lihat Data Keluarga
                        </a>
                    `;
                } else {
                    resultBox.className = 'result-box result-error';
                    resultBox.innerHTML = `<i class="ri-error-warning-line"></i> ${data.message}`;
                }
            })
            .catch(err => {
                resultBox.className = 'result-box result-error';
                resultBox.innerHTML = `<i class="ri-error-warning-line"></i> Error: ${err.message}`;
            });

        } catch (e) {
            resultBox.className = 'result-box result-error';
            resultBox.innerHTML = `<i class="ri-error-warning-line"></i> Format QR tidak valid: ${e.message}`;
        }
    }
</script>
@endsection