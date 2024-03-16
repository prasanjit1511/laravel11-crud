<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>laravel crud 11</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    

    <div class="bg-dark py-3">
      <h3 class="text-white text-center"> Simple laravel crud 11 </h3>
    </div>
  
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form action="" method="GET">
                    <div class="input-group">
                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control p-3 " placeholder="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>

        
        <div class="row justify-content-center">
            <div class="col-md-10  justify-content-start">
                <a type="button" onclick="window.location.href='{{ route('products.index') }}'" class="btn btn-dark">Reset</a>
           </div>
            <div class="col-md-10 d-flex justify-content-end">
             <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
            </div>
        </div>
      
       <div class="row d-flex justify-content-center ">
        
        @if (Session::has('success'))
            <div class="col-md-10">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="col-md-10">
                <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            </div>
        @endif

        <div class="col-md-10">
           
            <div class="card border-0 shadow-lg my-3">
             <div class="card-header bg-dark">
               <h3 class="text-white text-center">Product List</h3>
             </div>
             <div class="row justify-content-center mt-4">
             
            </div>

              <div class="card-body">
                    <table class="table">
                       <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Created_at</th>
                        <th>Action</th>
                       </tr>
                        @if ($products->isNotEmpty())
                        
                        @foreach ($products as $product)
                       
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image != "")
                                    <img width="50" src="{{ asset('uploads/products/'.$product->image) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>${{ $product->price }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('products.edit',$product->id) }}" class="btn btn-dark">Edit</a>
                                <a href="#" onclick="deleteProduct({{ $product->id }})" class="btn btn-danger">Delete</a>
                                <form id="delete-product-from-{{ $product->id }}" action="{{ route('products.destroy',$product->id) }}" method="POST">
                                 @csrf
                                 @method('delete')
                              </form>
                            </td>
                           </tr>
                        @endforeach
                        @endif
                       
                    </table>
              </div>

        </div>
        <div class="pagination justify-content-center m-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
       </div>
    </div>

  </body>
</html>

<script>
    function deleteProduct(id){
        if(confirm("Are you sure you want to product delete?")){
            document.getElementById("delete-product-from-"+id).submit();
        }
    }
</script>