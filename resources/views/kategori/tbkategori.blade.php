@extends('layout.lte')
@section('content')

<div class="card-body">
    <h5><a href="{{ url('/kategori/create') }}">Tanbah Data</a></h5>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Foto</th>
        <th>EDIT</th>
        <th>DELETE</th>
      </tr>
      </thead>
      <tbody>
        <?php
        $rec=DB::table('tbkategori')
            ->get();
        foreach ($rec as $key => $value) {
        ?>
        <tr>
            <th>{{ $value -> id  }}</th>
            <th>{{ $value -> nama  }}</th>
            <th><img src="{{ url('path/produk/' . $value->foto) }}" alt="" style="max-width: 100%;"></th>


            <th><a href="{{ url ('kategori/'.$value->id) }}"> Edit </th>
            <th><form action="{{ route('kategori.destroy', $value->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
            </form>  </th>


        </tr>

        <?php } ?>

      </tbody>

    </table>
  </div>
@endsection
