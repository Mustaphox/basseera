<?php $page_title = 'اتجاه القبلة'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">اتجاه القبلة</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            تحديد اتجاه الكعبة المشرفة بناءً على موقعك الجغرافي
        </p>
    </div>
</section>

<section class="py-5 min-vh-100 d-flex flex-column align-items-center">
    <div class="container text-center">
        
        <div id="qiblaStatus" class="alert alert-info border-0 shadow-sm rounded-4 mb-5 d-inline-block">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            جاري تحديد الموقع والبوصلة...
        </div>

        <div class="compass-container position-relative mx-auto" style="width: 300px; height: 300px; display: none;" id="compassContainer">
            <!-- Compass Dial -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Compass_Rose.svg" 
                 alt="بوصلة" 
                 class="img-fluid position-absolute top-0 start-0 w-100 h-100" 
                 id="compassDial"
                 style="transition: transform 0.2s ease-out; opacity: 0.8;">
            
            <!-- Kaaba Pointer -->
            <div class="position-absolute w-100 h-100 top-0 start-0" id="qiblaPointer" style="transition: transform 0.2s ease-out; z-index: 2;">
                <div class="position-absolute start-50 translate-middle-x" style="top: 10px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/8157/8157502.png" alt="الكعبة" width="40" height="40">
                </div>
            </div>
            
            <!-- Center Dot -->
            <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-primary shadow" style="width: 15px; height: 15px; z-index: 3;"></div>
        </div>
        
        <div class="mt-5" id="qiblaInfo" style="display: none;">
            <div class="card border-0 shadow-sm rounded-4 d-inline-block p-4">
                <h3 class="fw-bold mb-3">زاوية القبلة: <span id="qiblaAngle" class="text-primary">0</span>°</h3>
                <p class="text-muted mb-0"><i data-lucide="info" class="me-1"></i> يرجى وضع الجهاز بشكل مسطح وتحريكه على شكل رقم 8 لمعايرة البوصلة.</p>
                <button id="requestPermissionBtn" class="btn btn-outline-primary mt-3 rounded-pill d-none">السماح باستخدام مستشعر الاتجاه</button>
            </div>
        </div>
        
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const statusEl = document.getElementById('qiblaStatus');
    const container = document.getElementById('compassContainer');
    const info = document.getElementById('qiblaInfo');
    const dial = document.getElementById('compassDial');
    const pointer = document.getElementById('qiblaPointer');
    const angleText = document.getElementById('qiblaAngle');
    const reqBtn = document.getElementById('requestPermissionBtn');
    
    let qiblaAngle = 0;
    
    // Kaaba Coordinates
    const kaabaLat = 21.422487;
    const kaabaLng = 39.826206;

    function getQiblaAngle(lat, lng) {
        const phiK = kaabaLat * Math.PI / 180.0;
        const lambdaK = kaabaLng * Math.PI / 180.0;
        const phi = lat * Math.PI / 180.0;
        const lambda = lng * Math.PI / 180.0;
        
        const y = Math.sin(lambdaK - lambda);
        const x = Math.cos(phi) * Math.tan(phiK) - Math.sin(phi) * Math.cos(lambdaK - lambda);
        let qibla = Math.atan2(y, x) * 180.0 / Math.PI;
        return (qibla + 360) % 360;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                qiblaAngle = getQiblaAngle(position.coords.latitude, position.coords.longitude);
                angleText.textContent = qiblaAngle.toFixed(2);
                
                statusEl.style.display = 'none';
                container.style.display = 'block';
                info.style.display = 'block';
                
                pointer.style.transform = `rotate(\${qiblaAngle}deg)`;
                
                initCompass();
            },
            error => {
                statusEl.innerHTML = 'لم نتمكن من تحديد الموقع. يرجى تفعيل الـ GPS.';
                statusEl.className = 'alert alert-danger border-0 shadow-sm rounded-4';
            }
        );
    }

    function initCompass() {
        // For iOS 13+ devices
        if (typeof DeviceOrientationEvent.requestPermission === 'function') {
            reqBtn.classList.remove('d-none');
            reqBtn.addEventListener('click', () => {
                DeviceOrientationEvent.requestPermission()
                    .then(permissionState => {
                        if (permissionState === 'granted') {
                            reqBtn.classList.add('d-none');
                            window.addEventListener('deviceorientation', handleOrientation);
                        }
                    })
                    .catch(console.error);
            });
        } else {
            // Non iOS 13+ devices
            window.addEventListener('deviceorientationabsolute', handleOrientation);
        }
    }

    function handleOrientation(event) {
        let alpha = event.alpha;
        let webkitAlpha = event.webkitCompassHeading;
        
        let heading = null;
        if (webkitAlpha) {
            heading = webkitAlpha;
        } else if (alpha !== null) {
            heading = 360 - alpha;
        }
        
        if (heading !== null) {
            // Rotate the compass dial to match North
            dial.style.transform = `rotate(\${-heading}deg)`;
            // Pointer is fixed relative to north, so it rotates with the dial
            pointer.style.transform = `rotate(\${qiblaAngle - heading}deg)`;
        }
    }
});
</script>
