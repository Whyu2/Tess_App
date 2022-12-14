
            
        @extends('layout/main')
        @section('container')
            
            <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">History Pengajuan</h1>
                    
                    </div>

                    <!-- Content Row -->
            

                    <!-- Content Row -->
                    <div class="row">
                     

                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Approved</div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_y}}</div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Rejected</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_n}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List Perdin</h6>
                             
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    @if(session()->has('approved'))
                                    <div class="alert alert-success allert-dismissible fade show mt-1" role="alert">
                                      {{session('approved')}}
                                    </div>
                                    @endif
                                    @if(session()->has('rejected'))
                                    <div class="alert alert-danger allert-dismissible fade show mt-1" role="alert">
                                      {{session('rejected')}}
                                    </div>
                                    @endif
                                    <table id="example2" class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th >No</th>
                                                <th>Nama Pegawai</th>
                                                <th >Kota</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Detail</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $number=1; ?>
                                          @foreach ($perdin as $key => $p)
                                          <?php 
                                          $kota_asal = $f_perdin->kota($p->kota_asal_id);
                                          $kota_tujuan = $f_perdin->kota($p->kota_tujuan_id);
                                          $durasi =  $f_perdin->durasi($p->tgl_berangkat,$p->tgl_pulang);
                                          $status =  $f_perdin->status($p->konfirmasi);
                                          ?>
                                            <tr>
                                                <td>{{$number}}</td>
                                                <?php $number++; ?>
                                                <td>{{$p->user->nama}}</td>
                                                <td>{{$kota_asal->nama_kota}} <i class="fas fa-arrow-right"></i> {{$kota_tujuan->nama_kota}}</td>
                                                <td>{{tanggal_bulan($p->tgl_berangkat)}} - {{tanggal_bulan_tahun($p->tgl_pulang)}} ({{$durasi}} Hari)</span></td>
                                                <td >{{$p->keterangan}}</td>
                                                <th><a href="{{route('detail.perdin',$p->id)}}" class="btn btn-success btnku " ><i class="fas fa-eye"></i></th>
                                              </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                      
                    </div>

                    <!-- Content Row -->
            

                </div>
                <!-- /.container-fluid -->

                    {{-- modal delete --}}
                <div class="modal fade" id="DeleteModalKota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash fa-1x"></i> Hapus Kota</h5>
                          </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('kota.delete')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <label>Yakin akan ?</label>
                            <input type="hidden" id="id_delete" name="id_kota">
            
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>


                  
                @endsection
           