{{-- <script> --}}
    $(function(){
        $(".{{ $first_class }}").on("click", function(){
            if($(".{{ $second_class }}").length < 10){
                $(".{{ $second_class }}").append(
                    `<div class="row mt-2">
                        <div class="col-md-7">
                            <div class="mb-md-0">
                                <select class="form-control" name="{{ $first_input }}" required placeholder=" " >
                                    <option value="" selected disabled>--Select--</option>
                                    @forelse (($no_data === 'allowance') ? \App\Models\Dropdown::where('category_id', 1)->get() : \App\Models\Dropdown::where('category_id', 2)->get() as $dropdown)
                                        <option>{{ $dropdown->dropdown_name }}</option>
                                    @empty
                                        <option value="" disabled selected>No Data Found</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <select class="form-control" name="{{ $third_input }}" required>
                                    <option value="" selected disabled>--Select--</option>
                                    <option>Percentage</option>
                                    <option>Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <input class="form-control" type="number" min="0" step="0.01" name="{{ $second_input }}" required placeholder=" " />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" onclick="remove(this)" style="margin-top: 3px">Del</button>
                        </div>
                    </div>`
                );
            }
    
            document.querySelector('.{{ $no_data }}').style.display='none';
        });
    });