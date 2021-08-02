@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
             <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  @endforeach
             </ul>
         </div>
@endif

@if(session()->has('message'))
        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
        
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    
        </div>
@endif


