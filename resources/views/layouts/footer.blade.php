<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<footer class="container-fluid py-3 text-bg-dark shadow-lg" style="position:absolute;width:100%;">
    <div class="row justify-content-evenly pt-3">
        <div class="d-flex col-md-3 mb-3 align-items-end">
            <div class="">
                <div class="row">
                    <h4>Website Resmi<br>{{config('app.name' , 'Laravel')}}</h4> 
                </div>
                
                <br>
                {{-- detail(alamat, email, hp/wa, sosmed) --}}
                <div>
                    <h6 class="text-decoration-underline">Hubungi Kami</h6>
                    <h6>{{config('app.name', 'Nama Website')}}</h6>
                    <p>{{$master->alamat ?? 'Alamat Website'}}</p>
                    <i class="bi bi-telephone me-2"></i><span>{{$master->telp ?? '+62 ...'}}</span><br>
                    <i class="bi bi-whatsapp me-2"></i><span>{{$master->wa ?? '+62 ...'}}</span><br>
                    <a class="text-white" href="mailto:{{$master->email ?? ''}}"><i class="bi bi-envelope me-2"></i>{{$master->email ?? 'Email Address'}}</a><br>
                    <a class="text-white" href="https://facebook.com/{{$master->facebook ?? ''}}"><i class="bi bi-facebook me-2"></i>{{ucfirst($master->facebook ?? 'Facebook')}}</a><br>
                    <a class="text-white" href="https://instagram.com/{{$master->instagram ?? ''}}"><i class="bi bi-instagram me-2"></i>{{ucfirst($master->instagram ?? 'Instagram')}}</a><br>
                    <a class="text-white" href="https://youtube.com/{{$master->youtube ?? ''}}"><i class="bi bi-youtube me-2"></i>{{ucfirst($master->youtube ?? 'Youtube')}}</a><br>
                </div>
                <br>
                <div class="mt-2">
                    <h6 class="text-decoration-underline">Statistik Pengunjung Website</h6>
                    <div>
                        Today's visitors: {{ $today_visitors }} <br>
                        Today's page views: {{ $today_page_views }} <br>
                        Total visitors: {{ $total_visitors }} <br>
                        Total page views: {{ $total_page_views }}
                    </div>
                    
                </div>
            </div>
            
        </div>  
        {{-- Kolom Maps --}}
        <div class="col-md-3 mb-3 d-flex align-items-stretch">
            <div class="w-100 h-100">
                {!! str_replace('<iframe', '<iframe class="w-100 h-100" style="border:0;"', $master->maps ?? '<iframe class="w-100 h-100" style="border:0;"></iframe>') !!}
            </div>
        </div>

        {{-- Kolom Gambar --}}
        <div class="col-md-3 mb-3 d-flex align-items-stretch">
            <div class="row align-content-between" style="height:500px">
                <span class="mx-auto row w-50"><img src="/img/btg-112.png" class="w-100"></span>
                <a href="{{\Storage::exists('faq.txt') ? \Storage::get('faq.txt') : '#'}}" target="_blank"><span class="mx-auto row w-50"><img src="/img/FAQ.png" class="w-100"></span></a>
                <a href="{{$master->link}}" target="_blank"><span class="mx-auto row w-50"><img src="/img/kritik-saran.png" class="w-100"></span></a>
            </div>
        </div>
    </div>
    {{-- bagian bawah --}}
    <hr>
    <div class="container text-center">
        <div class="copyright text-sm text-lg-center">
            {{'Diskominfo@'}}@if(\Storage::exists('tgl.txt')){{Carbon\Carbon::parse(Storage::get('tgl.txt'))->format('mY')}} @endif <br>
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
                currentTimeElement.textContent = "Sekarang Pukul : " + formattedTime + " WITA";
            }

            // Update the time immediately
            updateTime();

            // Update the time every seconds
            setInterval(updateTime, 500);
        }
    }

    document.addEventListener('DOMContentLoaded', updateCurrentTime);
</script>