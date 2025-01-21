<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<footer class="container-fluid py-3 text-bg-dark shadow-lg" style="position:absolute;width:100%;">
    <div class="row justify-content-evenly">
        <div class="col-md-3 mb-3">
            <div class="row">
                <h4>Website Resmi<br>{{config('app.name' , 'Laravel')}}</h4> 
            </div>
            
            <br>
            {{-- detail(alamat, email, hp/wa, sosmed) --}}
            <div>
                <h6 class="border-bottom">Hubungi Kami</h6>
                <h6>{{config('app.name', 'Nama Website')}}</h6>
                <p>Jl. Damai No.41, Kanaan, Kec. Bontang Bar., Kota Bontang, Kalimantan Timur 75321</p>
                <i class="bi bi-telephone me-2"></i><span>+62 ...</span><br>
                <a class="text-white" href="mailto:"><i class="bi bi-envelope me-2"></i>E-mail website</a><br>
                <a class="text-white" href="#"><i class="bi bi-facebook me-2"></i>Facebook</a><br>
                <a class="text-white" href="#"><i class="bi bi-instagram me-2"></i>Instagram</a><br>
                <a class="text-white" href="#"><i class="bi bi-youtube me-2"></i>Youtube</a><br>
            </div>
            <div class="mt-2">
                <h6 class="border-bottom">Statistik Pengunjung Website</h6>
                Today's visitors: {{ $today_visitors }} <br>
                Today's page views: {{ $today_page_views }} <br>
                Total visitors: {{ $total_visitors }} <br>
                Total page views: {{ $total_page_views }} <br>
            </div>
        </div>  
        <div class="col-md-3 mb-3">
            <iframe class="h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.807954453327!2d117.45567087373068!3d0.13060639986810915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320a0dffab504e3b%3A0x752e6f4dda10df69!2sPuskesmas%20Bontang%20Barat!5e0!3m2!1sen!2sid!4v1737456208710!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            
        </div>
        <div class="col-md-3 mb-3">
            <img src="/img/112.jpeg" frameborder="0" class="w-100">
        </div>
    </div>
    {{-- bagian bawah --}}
    <hr>
    <div class="container text-center">
        <div class="copyright text-sm text-lg-center">
            {{'Diskominfo@'.Carbon\Carbon::now()->format('mY')}} <br>
            <b id="current-time-placeholder" class="text-center text-sm text-lg-center"></b>
        </div>
        
    </div>
    
</footer>
<script>
    function updateCurrentTime() {
        var currentTimeElement = document.getElementById('current-time-placeholder');

        if (currentTimeElement) {
            function updateTime() {
                var now = new Date();
                var formattedTime = now.toLocaleTimeString('en-US', { hour12: false });
                currentTimeElement.textContent = "Sekarang Jam : " + formattedTime + " WITA";
            }

            // Update the time immediately
            updateTime();

            // Update the time every seconds
            setInterval(updateTime, 500);
        }
    }

    document.addEventListener('DOMContentLoaded', updateCurrentTime);
</script>