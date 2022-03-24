<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">

            Multi Picture

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">




                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Multi Image
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Image</label>
                                    <input name="image" type="file" class="form-control" type="text" />


                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="mt-3 btn btn-primary" id="exampleInputEmail1">Add
                                    Image</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </div>




    </div>

    </div>
</x-app-layout>
