@extends('tutorial.layout')

@section('content')
@php
    $no = 1;
@endphp
<div class="card mt-4">
    <div class="card-body">
        <h5>Recruitment</h5>
        <ul>
            <li>Leptop sudah terinstal XAMPP</li>
            <li>Leptop sudah terinstal Composer</li>
            <li>Versi PHP minimal 7.2</li>
        </ul>
    </div>
</div>
<table class="table table-bordered mt-3" width="100%">
    <thead>
        <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" width="100%">Tutorial</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka aplikasi XAMPP
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Aktifkan Apache dan MySQL
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka CMD atau Terminal
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Masuk ke directory untuk menyimpan Project<br>
                Contoh: <b>cd Documents</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Copy text di bawah ini<br>
                <u>composer create-project laravel/laravel <span class="text-danger">latihan-laravel<span></u>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Paste di CMD atau Terminal
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Tunggu sampai selesai
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Tulis <b>cd <span class="text-danger">latihan-laravel<span></b> di CMD atau Terminal
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Tulis <b>php artisan serve</b> di CMD atau Terminal
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka link ini <a href="http://127.0.0.1:8000" target="_blank">http://127.0.0.1:8000</a>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buatlah database MySQL dengan nama <span class="text-danger">latihan_laravel_db</span>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka Project Laravel kalian di Code Editor
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Mengkoneksikan database dengan Aplikasi Laravel kita dengan cara: <br>
                1. Buka file <b>.env</b> <br>
                2. Edit bagian ini seperti di bawah: <br>
                <pre>
                    <code class="language-php">
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=latihan_laravel_db
DB_USERNAME=root
DB_PASSWORD=
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Membersihkan cache setelah merubah file <b>.env</b> dengan cara: <br>
                <b>php artisan cache:clear</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Membuat Model dan Migrasi dengan cara: <br>
                <b>php artisan make:model Product -m</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka folder <b>database/migrations</b>, kemudian buka file <b>..._create_products_table.php</b> <br>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah coding pada fungsi <b>up</b> menjadi seperti dibawah: <br>
                <pre>
                    <code class="language-php">
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('merek');
        $table->string('harga');
        $table->timestamps();
    });
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Kemudian migrasi tabel products yang sudah kita buat dengan cara menulis command seperti dibawah: <br>
                <b>php artisan migrate</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Jika sudah di migrasi, kita harus merubah code pada model Product
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka folder <b>app/Models</b>, kemudian buka file <b>Product.php</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah coding pada class <b>Product</b> menjadi seperti dibawah: <br>
                <pre>
                    <code class="language-php">
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'merek',
        'harga',
    ];
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Kita sudah membuat Migrasi dan Model, selanjutnya kita harus membuat Controller
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Untuk membuat controller tulis command seperti dibawah: <br>
                <b>php artisan make:controller ProductController -r</b>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Buka file <b>ProductController.php</b> di app\Http\Controllers
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Hubungkan mode Product ke dalam ProductController dengan cara menambahkan code <b>use App\Models\Product;</b> di bawah <b>use Illuminate\Http\Request;</b> <br>
                <pre>
                    <code class="language-php">
use Illuminate\Http\Request;
use App\Models\Product;
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>index</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function index()
{
    $products = Product::all();

    return view('product.tampil', compact('products'));
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>create</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function create()
{
    return view('product.tambah');
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>store</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function store(Request $request)
{
    $product = Product::create([
        'nama' => $request->nama,
        'merek' => $request->merek,
        'harga' => $request->harga,
    ]);

    return redirect('/product/tampil');
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>edit</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function edit($id)
{
    $product = Product::find($id);

    return view('product.ubah', compact('product'));
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>update</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function update(Request $request, $id)
{
    $product = Product::find($id)->update([
        'nama' => $request->nama,
        'merek' => $request->merek,
        'harga' => $request->harga,
    ]);

    return redirect('/product/tampil');
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Ubah fungsi <b>destroy</b> menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
public function destroy($id)
{
    $product = Product::find($id)->delete();

    return redirect('/product/tampil');
}
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Selanjutnya kita buat tampilan nya, buat folder product dan file berikut kedalam folder <b>resources/views</b>: <br>
                1. layout.blade.php<br>
                2. tampil.blade.php (di dalam folder product)<br>
                3. ubah.blade.php (di dalam folder product)<br>
                4. tambah.blade.php (di dalam folder product)<br>
                <img src="{{asset('ss-views.png')}}" height="200px" alt="">
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Isi file <b>layout.blade.php</b> dengan code dibawah:
                <pre>
                    <code class="language-html">
&lt;!doctype html>
&lt;html lang="en">

&lt;head>
    &lt;meta charset="utf-8">
    &lt;meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    &lt;link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    &lt;link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    &lt;title>Latihan Laravel&lt;/title>

    &commat;stack('style')
&lt;/head>

&lt;body>

    &lt;nav class="navbar navbar-expand-lg navbar-light bg-light">
        &lt;div class="container">
            &lt;a class="navbar-brand" href="{{url('/')}}">
                SMK N 1 PWT
            &lt;/a>
            &lt;button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation"
            >
                &lt;span class="navbar-toggler-icon">&lt;/span>
            &lt;/button>
            &lt;div class="collapse navbar-collapse" id="navbarNav">
                &lt;ul class="navbar-nav ml-auto">
                    &lt;li class="nav-item active">
                        &lt;a class="nav-link" href="#">Hi, Kamu&lt;/a>
                    &lt;/li>
                &lt;/ul>
            &lt;/div>
        &lt;/div>
    &lt;/nav>

    &lt;div class="container mt-5">
        &commat;yield('content')
    &lt;/div>

    &lt;script src="https://code.jquery.com/jquery-3.5.1.slim.min.js">&lt;/script>
    &lt;script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js">&lt;/script>

    &commat;stack('script')
&lt;/body>

&lt;/html>
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Isi file <b>tampil.blade.php</b> dengan code dibawah:
                <pre>
                    <code class="language-html">
&commat;extends('layout')

&commat;section('content')

&commat;if (Session::has('message'))
    &lt;div class="alert alert-info">&lcub;&lcub; Session::get('message') &rcub;&rcub;&lt;/div>
&commat;endif
&lt;div class="card">
    &lt;div class="card-header d-flex justify-content-between align-items-center">
        &lt;h4>Product&lt;/h4>
        &lt;a href="/product/create" class="btn btn-primary">Tambah&lt;/a>
    &lt;/div>
    &lt;div class="card-body">
        &lt;table width="100%" class="table table-bordered">
            &lt;tr>
                &lt;td>No&lt;/td>
                &lt;td width="30%">Nama&lt;/td>
                &lt;td width="30%">Merek&lt;/td>
                &lt;td width="30%">Harga&lt;/td>
                &lt;td width="10%">Aksi&lt;/td>
            &lt;/tr>
            &commat;foreach($products as $index => $product)
            &lt;tr>
                &lt;td>&lcub;&lcub;&dollar;index + 1&rcub;&rcub;&lt;/td>
                &lt;td>&lcub;&lcub;&dollar;product->nama&rcub;&rcub;&lt;/td>
                &lt;td>&lcub;&lcub;&dollar;product->merek&rcub;&rcub;&lt;/td>
                &lt;td>&lcub;&lcub;&dollar;product->harga&rcub;&rcub;&lt;/td>
                &lt;td>
                    &lt;a href="/product/&lcub;&lcub;&dollar;product->id&rcub;&rcub;/edit" class="text-primary">
                        &lt;i class="ri-edit-box-line">&lt;/i>
                    &lt;/a>
                    &lt;a class="text-danger"
                        href="#" onclick="event.preventDefault(); document.getElementById('delete-form-&lcub;&lcub;&dollar;product->id&rcub;&rcub;').submit();">
                        &lt;i class="ri-delete-bin-line">&lt;/i>
                    &lt;/a>
                    &lt;form id="delete-form-&lcub;&lcub;&dollar;product->id&rcub;&rcub;" action="/product/&lcub;&lcub;&dollar;product->id&rcub;&rcub;"
                        method="POST" style="display: none;">
                        &commat;csrf
                        &commat;method('DELETE')
                    &lt;/form>
                &lt;/td>
            &lt;/tr>
            &commat;endforeach
        &lt;/table>
    &lt;/div>
&lt;/div>
&commat;endsection

                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Isi file <b>tambah.blade.php</b> dengan code dibawah:
                <pre>
                    <code class="language-html">
&commat;extends('layout')

&commat;section('content')
&lt;div class="card">
    &lt;div class="card-header d-flex justify-content-between align-items-center">
        &lt;a href="/product" class="btn btn-outline-danger">Kembali&lt;/a>
        &lt;h4>Tambah Product&lt;/h4>
    &lt;/div>
    &lt;div class="card-body">
        &lt;form action="/product" method="POST">
            &commat;csrf
            &lt;div class="form-group">
                &lt;label>Nama&lt;/label>
                &lt;input type="text" name="nama" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;div class="form-group">
                &lt;label>Merek&lt;/label>
                &lt;input type="text" name="merek" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;div class="form-group">
                &lt;label>Harga&lt;/label>
                &lt;input type="number" name="harga" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;button type="submit" class="btn btn-primary">
                Simpan
            &lt;/button>
        &lt;/form>
    &lt;/div>
&lt;/div>
&commat;endsection

                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Isi file <b>ubah.blade.php</b> dengan code dibawah:
                <pre>
                    <code class="language-html">
&commat;extends('layout')

&commat;section('content')
&lt;div class="card">
    &lt;div class="card-header d-flex justify-content-between align-items-center">
        &lt;a href="/product" class="btn btn-outline-danger">Kembali&lt;/a>
        &lt;h4>Ubah Product&lt;/h4>
    &lt;/div>
    &lt;div class="card-body">
        &lt;form action="/product/&lcub;&lcub;&dollar;product->id&rcub;&rcub;" method="POST">
            &commat;csrf
            &commat;method('PUT')
            &lt;div class="form-group">
                &lt;label>Nama&lt;/label>
                &lt;input type="text" value="&lcub;&lcub;&dollar;product->nama&rcub;&rcub;" name="nama" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;div class="form-group">
                &lt;label>Merek&lt;/label>
                &lt;input type="text" value="&lcub;&lcub;&dollar;product->merek&rcub;&rcub;" name="merek" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;div class="form-group">
                &lt;label>Harga&lt;/label>
                &lt;input type="number" value="&lcub;&lcub;&dollar;product->harga&rcub;&rcub;" name="harga" class="form-control" placeholder="Tulis disini...">
            &lt;/div>
            &lt;button type="submit" class="btn btn-primary">
                Simpan
            &lt;/button>
        &lt;/form>
    &lt;/div>
&lt;/div>
&commat;endsection
                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                kemudian buka file <b>routes/web.php</b>, ganti kode menjadi seperti dibawah:
                <pre>
                    <code class="language-php">
&lt;?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('product');
});

Route::resource('product', App\Http\Controllers\ProductController::class);

                    </code>
                </pre>
            </td>
        </tr>
        <tr>
            <th scope="row">{{$no++}}</th>
            <td>
                Jalankan aplikasi kalian dengan command <b>php artisan serve</b> <br>
                kemudian buka link ini <a href="http://127.0.0.1:8000" target="_blank">http://127.0.0.1:8000</a>
            </td>
        </tr>
    </tbody>
</table>
@endsection
