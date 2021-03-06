<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">

            All Category

        </h2>
    </x-slot>

    <div class="py-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="card-header">
                                    All Category
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">SL No.</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- @php($i =1) --}}
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>
                                                <td>{{ $category->category_name }}</td>
                                                {{-- <td>{{ $category->user_id }}</td> --}}
                                                {{-- <td>{{ $category->user->name }}</td> --}}
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    @if ($category->created_at == NULL)
                                                        <span class="text-danger">No Date Set</span>
                                                        @else
                                                        {{-- eloquent format --}}
                                                        {{-- {{ $category->created_at->diffForHumans() }} --}}

                                                        {{-- query builder format --}}
                                                        {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{ url('category/edit/'.$category->id) }}" class="btn btn-info">Edit</a>
                                                    <a href="{{ url('softdelete/category/'.$category->id) }}" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    </table>
                                    {{ $categories->links() }}
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        Add Category
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('store.category') }}" method="POST">
                                            @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Category Name</label>
                                            <input name="category_name" type="text" class="form-control" type="text" />
                                             @error('category_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                             @enderror
                                        </div>
                                        <button type="submit" class="mt-3 btn btn-primary" id="exampleInputEmail1">Add Category</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                    </div>


                </div>



                {{-- trash section --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">

                                {{-- @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times</span>
                                        </button>
                                    </div>
                                @endif --}}

                                <div class="card-header">
                                    Trash Lists
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">SL No.</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($trashCat as $category)
                                        <tr>
                                            <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>
                                            <td>{{ $category->category_name }}</td>

                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if ($category->created_at == NULL)
                                                    <span class="text-danger">No Date Set</span>
                                                    @else
                                                   {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{ url('category/restore/'.$category->id) }}" class="btn btn-info">Restore</a>
                                                <a href="{{ url('permanentdelete/category/'.$category->id) }}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                    </table>
                                    {{ $trashCat->links() }}
                            </div>
                        </div>

                    </div>


                </div>
            </div>

    </div>
</x-app-layout>
