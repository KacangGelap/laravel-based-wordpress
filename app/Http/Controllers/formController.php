<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\opd;
use App\Models\informasi;
use App\Models\keberatan;
use App\Models\survey;
use Carbon\Carbon;
class formController extends Controller
{
    //controller ini buat menampung form layanan ajuan informasi, keberatan, dan survey kepuasan masyarakat
    public function informasi_index()
    {
        $opd = opd::all();
        
        $perPage = request('per_page', 10);
        $data = informasi::with('opd')->orderByDesc('created_at')->paginate($perPage);
        //search
        if (request('q')) {
            //validate search input
            request()->validate([
                'q' => 'required|string|min:2|max:255',
            ],[
                'q.required' => 'Kata kunci pencarian tidak boleh kosong.',
                'q.string' => 'Kata kunci pencarian harus berupa teks.',
                'q.min' => 'Kata kunci pencarian minimal :min karakter.',
                'q.max' => 'Kata kunci pencarian maksimal :max karakter.',
            ]);
            $search = request('q');
            $data = informasi::with('opd')
                ->Where('nama_pemohon', 'like', "%$search%")
                ->paginate($perPage);
        }
        return view('halaman.form.informasi', compact('data', 'opd'));
    }
    public function informasi_store(Request $request){
        $q = $request->validate([
            'kategori_permohonan' => 'required|string',
            'nama_pemohon' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|in:KTP,Nomor Badan Hukum,Nomor Surat Mahasiswa,Instansi',
            'no_identitas' => 'nullable|string|max:255',
            'alamat_pemohon' => 'nullable|string|max:255',
            'pekerjaan_pemohon' => 'nullable|string|max:255',
            'no_hp_pemohon' => 'nullable|string|max:15',
            'email_pemohon' => 'nullable|email|max:255',
            'rincian_kebutuhan' => 'required|string|max:255',
            'tujuan_informasi' => 'required|string|max:255',
            'memperoleh_informasi' => 'required|string|max:255',
            'mendapatkan_informasi' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5000', // 2MB
        ]);
        // dd($request->jenis_identitas);
        try {
            do {
                $kode = 'INF-' . random_int(10000000, 99999999);
            } while (informasi::where('kode_permohonan', $kode)->exists());
            informasi::create([
                'kode_permohonan' => $kode,
                'kategori_permohonan' => $request->kategori_permohonan,
                'opd_id' => $request->opd,
                'nama_pemohon' => $request->nama_pemohon,
                'jenis_permohonan' => $request->jenis_identitas,
                'jenis_identitas' => $request->jenis_identitas,
                'nomor_identitas' => $request->no_identitas,
                'alamat_pemohon' => $request->alamat_pemohon,
                'pekerjaan_pemohon' => $request->pekerjaan_pemohon,
                'hp_pemohon' => $request->no_hp_pemohon,
                'email_pemohon' => $request->email_pemohon,
                'rincian_kebutuhan' => $request->rincian_kebutuhan,
                'tujuan_informasi' => $request->tujuan_informasi,
                'cara_memperoleh_informasi' => $request->memperoleh_informasi,
                'cara_mendapatkan_informasi' => $request->mendapatkan_informasi,
                'identitas' => $request->file('file_identitas')->store('identitas', 'public')
            ]);
            // dd($data);
            return redirect()->back()->with('sukses', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    public function informasi_detail(string $id){
        $data = informasi::where('kode_permohonan', $id)->firstOrFail();
        return view('halaman.form.informasi_detail', compact('data'));
    }
    public function keberatan_index()
    {
        $perPage = request('per_page', 10);
        $data = keberatan::orderByDesc('created_at')->paginate($perPage);
        //search
        if (request('q')) {
            //validate search input
            request()->validate([
                'q' => 'required|string|min:2|max:255',
            ],[
                'q.required' => 'Kata kunci pencarian tidak boleh kosong.',
                'q.string' => 'Kata kunci pencarian harus berupa teks.',
                'q.min' => 'Kata kunci pencarian minimal :min karakter.',
                'q.max' => 'Kata kunci pencarian maksimal :max karakter.',
            ]);
            $search = request('q');
            $data = keberatan::Where('nama_pemohon', 'like', "%$search%")
                ->paginate($perPage);
        }
        return view('halaman.form.keberatan', compact('data'));
        
    }
    public function keberatan_store(Request $request){
        // dd($request->all());
        $q = $request->validate([
            'alasan_keberatan' => 'required|string',
            'nama_pemohon' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'hp_pemohon' => 'required|string|max:15',
            'rincian_keberatan' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
        ]);
        try {
            do {
                $kode = 'KEB-' . random_int(10000000, 99999999);
            } while (keberatan::where('kode_ajuan', $kode)->exists());
            keberatan::create([
                'kode_ajuan' => $kode,
                'alasan_keberatan' => $request->alasan_keberatan,
                'nama_pemohon' => $request->nama_pemohon,
                'alamat' => $request->alamat,
                'hp_pemohon' => $request->hp_pemohon,
                'rincian_keberatan' => $request->rincian_keberatan,
                'identitas' => $request->file('file_identitas')->store('identitas', 'public')
            ]);
            // dd(keberatan::all());
            return redirect()->back()->with('sukses', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    public function keberatan_detail(string $id){
        $data = keberatan::where('kode_ajuan', $id)->firstOrFail();
        return view('halaman.form.keberatan_detail', compact('data'));
    }
    public function survey(){
        return view('halaman.form.survey');
    }
    public function survey_store(Request $request){
        $q = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|in:> 30 Tahun,25 - 30 Tahun,18 - 25 Tahun,< 18 Tahun',
            'email' => 'required|email|max:255',
            'kategori_responden' => 'required|in:Mahasiswa/Pelajar,Lembaga/Instansi,Perorangan',
            'pelayanan' => 'required|in:Sangat Baik,Baik,Cukup Baik,Buruk,Sangat Buruk',
            'kecepatan_pelayanan' => 'required|in:Sangat Baik,Baik,Cukup Baik,Buruk,Sangat Buruk',
            'kesesuaian_informasi' => 'required|in:Sangat Baik,Baik,Cukup Baik,Buruk,Sangat Buruk',
            'kualitas_pelayanan' => 'required|in:Sangat Baik,Baik,Cukup Baik,Buruk,Sangat Buruk',
            'saran' => 'nullable|string|max:255',
        ]);
        try {
            survey::create($q);
            return redirect()->back()->with('sukses', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    public function statistik(){
        if (request('year')) {
            $q = request()->validate(['year' => 'date_format:Y']);
            $year = $q['year'];
        } else {
            $year = Carbon::parse(now())->translatedFormat('Y');
        }
        //inf
        $infQuery = informasi::query()->whereYear('created_at', $year)->with('opd');
        $inf = $infQuery->orderByDesc('created_at')->get();
        $infAll = $inf->count();
        $infProses = (clone $infQuery)->where('status', 'Diproses')->count();
        $infSelesai = (clone $infQuery)->where('status', 'Selesai')->count();
        $infDitolak = (clone $infQuery)->where('status', 'Ditolak')->count();

        $kebQuery = keberatan::query()->whereYear('created_at', $year);
        $keb = $kebQuery->orderByDesc('created_at')->get();
        $kebAll = $keb->count();
        $kebDitolak = (clone $kebQuery)->where('status','Ditolak')->count();

        $sur = collect(range(1, 12))->map(function ($month) use ($year) {
            $items = survey::query()
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();

            return [
                'month' => Carbon::createFromDate($year, $month, 1)->translatedFormat('F'),
                'count' => $items->count(),
                'data' => $items,
            ];
        })->values();

        $surveyData = survey::query()->whereYear('created_at', $year)->get();
        $ratingValues = [
            'Sangat Baik' => 5,
            'Baik' => 4,
            'Cukup Baik' => 3,
            'Buruk' => 2,
            'Sangat Buruk' => 1,
        ];
        $averageRating = function (string $field) use ($surveyData, $ratingValues) {
            if ($surveyData->isEmpty()) {
                return 0;
            }

            $average = $surveyData
                ->map(fn ($item) => $ratingValues[$item->$field] ?? 0)
                ->avg();

            return round($average, 2);
        };

        $statistik = [
            'informasi' => [
                'total' => $infAll,
                'diproses' => $infProses,
                'selesai' => $infSelesai,
                'ditolak' => $infDitolak,
            ],
            'keberatan' => [
                'total' => $kebAll,
                'ditolak' => $kebDitolak,
            ],
            'survey' => [
                'total' => $sur->sum('count'),
                'per_bulan' => $sur,
                'avg_pelayanan' => $averageRating('pelayanan'),
                'avg_kecepatan_pelayanan' => $averageRating('kecepatan_pelayanan'),
                'avg_kesesuaian_informasi' => $averageRating('kesesuaian_informasi'),
                'avg_kualitas_pelayanan' => $averageRating('kualitas_pelayanan'),
            ],
        ];

        return view('halaman.form.statistik', compact('year', 'inf', 'keb', 'sur', 'statistik', 'infAll', 'infProses', 'infSelesai', 'infDitolak', 'kebAll', 'kebDitolak'));
    }

    //auth
    public function informasi(){
        $perPage = request('per_page', 5);
        $statuses = ['Dikirim', 'Diproses', 'Selesai', 'Ditolak'];
        $data = [];

        foreach ($statuses as $status) {
            $query = informasi::with('opd')
                ->where('status', $status)
                ->orderByDesc('created_at');

            if (request('q')) {
                $search = trim(request('q'));
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pemohon', 'like', "%{$search}%")
                        ->orWhere('kode_permohonan', 'like', "%{$search}%");
                });
            }

            $pageName = 'page_' . strtolower(str_replace([' ', '-'], '_', $status));
            $data[$status] = $query->paginate($perPage, ['*'], $pageName);
        }

        return view('halaman.form.informasi_list', compact('data', 'statuses', 'perPage'));
    }
    public function informasi_update(Request $request, string $id){
        $q = $request->validate([
            'status' => 'required|string|in:Dikirim,Diproses,Selesai,Ditolak'
        ]);
        // dd($request->all());
        try {
            informasi::findOrFail($id)->update(['status' => $q['status']]);
            return redirect()->back()->with('sukses', 'Status berhasil diperbarui');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Terjadi Kesalahan',
            ], 500);
        }
    }
    public function keberatan(){
        $perPage = request('per_page', 5);
        $statuses = ['Dikirim', 'Diproses', 'Selesai', 'Ditolak'];
        $data = [];

        foreach ($statuses as $status) {
            $query = keberatan::where('status', $status)
                ->orderByDesc('created_at');

            if (request('q')) {
                $search = trim(request('q'));
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pemohon', 'like', "%{$search}%")
                        ->orWhere('kode_permohonan', 'like', "%{$search}%");
                });
            }

            $pageName = 'page_' . strtolower(str_replace([' ', '-'], '_', $status));
            $data[$status] = $query->paginate($perPage, ['*'], $pageName);
        }

        return view('halaman.form.keberatan_list', compact('data', 'statuses', 'perPage'));
    }
    public function keberatan_update(Request $request, string $id){
         $q = $request->validate([
            'status' => 'required|string|in:Dikirim,Diproses,Selesai,Ditolak'
        ]);
        // dd($request->all());
        try {
            keberatan::findOrFail($id)->update(['status' => $q['status']]);
            return redirect()->back()->with('sukses', 'Status berhasil diperbarui');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Terjadi Kesalahan',
            ], 500);
        }
    }
}
