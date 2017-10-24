<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="row">
  <div class="col-md-12">
    <h2 style="font-size:15px;">Laporan Ta'Awun {{ $nama_bmt }} - {{ $no_induk_bmt }}</h2>
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title" style="font-size:14px;">Periode {{ $laporan }}</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered" style="border: 1px solid black;border-collapse: collapse;font-size: 16px;">
          <thead>
            <tr style="border: 1px solid black;border-collapse: collapse;font-size: 16px; background:cyan">
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">No</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">No KTP</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Kode Anggota</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Nama Anggota</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Tanggal Lahir</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Usia</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Pekerjaan</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Alamat</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Kode Pos</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jenis Kelamin</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">No Telp</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jenis Usaha</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Lokasi Usaha</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jenis Plafon</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Pembiayaan</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jangka Waktu</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jatuh Tempo</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Status Akad</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Disetujui Oleh</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Tanggal Klaim</th>
              <th align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 13px;">Jumlah Iuran</th>
            </tr>
          </thead>
          <tbody>
          @php
            $number = 1;
          @endphp
          @foreach ($rekap as $key)
            <tr style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$number++}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["no_ktp"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["kode_anggota"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["nama_anggota"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["tanggal_lahir"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["usia"]}}</td>
              <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["pekerjaan"]}}</td>
              <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["alamat"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["kode_pos"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["jenis_kelamin"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["no_telp"]}}</td>
              <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["jenis_usaha"]}}</td>
              <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["lokasi_usaha"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["jenis_plafon"]}}</td>
              <td align="right" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{number_format($key["jumlah_pembiayaan"],0,'.','.')}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["jangka_waktu"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["jatuh_tempo"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["status_akad"]}}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["approve_by"] or "-" }}</td>
              <td align="center" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{$key["tanggal_klaim"] or "-" }}</td>
              <td align="right" style="border: 1px solid black;border-collapse: collapse;font-size: 12px;">{{number_format($key["jumlah_iuran"],0,'.','.')}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <br>

        <table class="table table-bordered" style="border: 1px solid black;border-collapse: collapse;font-size: 18px; background:cyan;">
          <tr style="border: 1px solid black;border-collapse: collapse;font-size: 18px;">
            <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 16px;">Jumlah Pembiayaan</td>
            <td align="right" style="border: 1px solid black;border-collapse: collapse;font-size: 18px;"><strong>{{ $jumlahPembiayaan }}</strong></td>
          </tr>
          <tr>
            <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 16px;">Total Plafon</td>
            <td align="right" style="border: 1px solid black;border-collapse: collapse;font-size: 18px;"><strong>Rp. {{ number_format($totalPlafon,0,'.','.') }},-</strong></td>
          </tr>
          <tr>
            <td align="left" style="border: 1px solid black;border-collapse: collapse;font-size: 16px;">Total Sumbangan</td>
            <td align="right" style="border: 1px solid black;border-collapse: collapse;font-size: 18px;"><strong>Rp. {{ number_format($totalIuran,0,'.','.') }},-</strong></td>
          </tr>
        </table>
        {{-- <span style="font-size:16px;"><strong>Jumlah Pembiayaan: {{ $jumlahPembiayaan }}</strong></span><br>
        <span style="font-size:16px;"><strong>Total Plafon: Rp. {{ number_format($totalPlafon,0,'.','.') }},-</strong></span><br>
        <span style="font-size:16px;"><strong>Total Sumbangan: Rp. {{ number_format($totalIuran,0,'.','.') }},-</strong></span> --}}

      </div>
    </div>
  </div>
</div>
