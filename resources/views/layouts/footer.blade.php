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
                <p>{{$master->alamat ?? 'Alamat Website'}}</p>
                <i class="bi bi-telephone me-2"></i><span>{{$master->telp ?? '+62 ...'}}</span><br>
                <a class="text-white" href="mailto:{{$master->email ?? ''}}"><i class="bi bi-envelope me-2"></i>{{$master->email ?? 'Email Address'}}</a><br>
                <a class="text-white" href="https://facebook.com/{{$master->facebook ?? ''}}"><i class="bi bi-facebook me-2"></i>{{ucfirst($master->facebook ?? 'Facebook')}}</a><br>
                <a class="text-white" href="https://instagram.com/{{$master->instagram ?? ''}}"><i class="bi bi-instagram me-2"></i>{{ucfirst($master->instagram ?? 'Instagram')}}</a><br>
                <a class="text-white" href="https://youtube.com/{{$master->youtube ?? ''}}"><i class="bi bi-youtube me-2"></i>{{ucfirst($master->youtube ?? 'Youtube')}}</a><br>
            </div>
            <div class="mt-2">
                <h6 class="border-bottom">Statistik Pengunjung Website</h6>
                Today's visitors: {{ $today_visitors }} <br>
                Today's page views: {{ $today_page_views }} <br>
                Total visitors: {{ $total_visitors }} <br>
                Total page views: {{ $total_page_views }} <br>
            </div>
        </div>  
        <div class="col-md-3 mb-3 d-flex align-items-stretch">
                {!! $master->maps ?? '<iframe> </iframe>'!!}
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