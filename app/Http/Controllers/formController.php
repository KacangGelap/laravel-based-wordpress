<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\opd;
use App\Models\informasi;
use App\Models\keberatan;
use App\Models\survey;

class formController extends Controller
{
    //controller ini buat menampung form layanan ajuan informasi, keberatan, dan survey kepuasan masyarakat
    public function informasi_index()
    {
        $data = informasi::with('opd')->paginate(10);
        $opd = opd::all();
        
        $perPage = request('per_page', 10);
        $data = informasi::with('opd')->paginate($perPage);
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
            'opd' => 'required|exists:opd,id',
            'nama_pemohon' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|in:KTP,Nomor Badan Hukum,Nomor Surat Mahasiswa',
            'no_identitas' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string|max:255',
            'pekerjaan_pemohon' => 'required|string|max:255',
            'no_hp_pemohon' => 'required|string|max:15',
            'email_pemohon' => 'required|email|max:255',
            'rincian_kebutuhan' => 'required|string|max:255',
            'tujuan_informasi' => 'required|string|max:255',
            'memperoleh_informasi' => 'required|string|max:255',
            'mendapatkan_informasi' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
        ]);
        // dd($request->all());
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
        $data = keberatan::paginate(10);
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
        //
    }
}
