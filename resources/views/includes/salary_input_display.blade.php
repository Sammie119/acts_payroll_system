<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#"><strong>{{ $header }}</strong></a>
    </li>
    
    <button type="button" class="btn btn-success {{ $first_class }}" style="margin-left: 30px; border-radius: 40px; margin-bottom: 2px;" >Add New</button> 
    
</ul>

<div class="row mt-2">
    <div class="col-md-7">Description</div>
    <div class="col-md-2">Rate</div>
    <div class="col-md-2">Amount</div>
    <div class="col-md-1" style="white-space: nowrap">Action</div>
</div>

<div class="{{ $second_class }}">
    
    @if ($no_data === 'allowance')
        @if (empty($pay->incomes))
            <div class="row mt-2 {{ $no_data }}">
                <div class="col-md-12">
                    No data Found
                </div>
            </div>
        @else
            @foreach ($pay->incomes as $i => $income)
                <div class="row mt-2">
                    <div class="col-md-7">
                        <div class="mb-md-0">
                            <select class="form-control" name="incomes[]" required placeholder=" " >
                                <option selected>{{ $income }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-1">
                            <select class="form-control" name="rate_incomes[]" required>
                                <option {{ ($pay->rate_incomes[$i] === 'Percentage') ? 'selected' : null }}>Percentage</option>
                                <option {{ ($pay->rate_incomes[$i] === 'Amount') ? 'selected' : null }}>Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-1">
                            <input class="form-control" type="number" min="0" step="0.01" name="amount_incomes[]" value="{{ $pay->amount_incomes[$i] }}" required placeholder=" " />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-danger btn-sm" onclick="remove(this)" style="margin-top: 3px">Del</button>
                    </div>
                </div>
            @endforeach
        @endif
    @elseif ($no_data === 'deduction')
        @if (empty($pay->deductions) && empty($loans[0]))
            <div class="row mt-2 {{ $no_data }}">
                <div class="col-md-12">
                    No data Found
                </div>
            </div>
        @else
            {{-- Deductions --}}
            @if(!empty($pay->deductions))
                @foreach ($pay->deductions as $i => $deduction)
                    <div class="row mt-2">
                        <div class="col-md-7">
                            <div class="mb-md-0">
                                <select class="form-control" name="deductions[]" required placeholder=" " >
                                    <option selected>{{ $deduction }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <select class="form-control" name="rate_deductions[]" required>
                                    <option {{ ($pay->rate_deductions[$i] === 'Percentage') ? 'selected' : null }}>Percentage</option>
                                    <option {{ ($pay->rate_deductions[$i] === 'Amount') ? 'selected' : null }}>Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <input class="form-control" type="number" min="0" step="0.01" name="amount_deductions[]" value="{{ $pay->amount_deductions[$i] }}" required placeholder=" " />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" onclick="remove(this)" style="margin-top: 3px">Del</button>
                        </div>
                    </div>
                @endforeach
            @endif
            
            {{-- loan --}}
            @if(!empty($loans[0]))
                @foreach ($loans as $i => $loan)
                    <input type="hidden" name="loan_id[]" value="{{ $loan->loan_id }}">
                    <div class="row mt-2">
                        <div class="col-md-7">
                            <div class="mb-md-0">
                                <select class="form-control" name="loan[]" required placeholder=" " >
                                    <option selected>{{ $loan->description }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <select class="form-control" name="rate_loan[]" required>
                                    <option selected>Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-1">
                                <input class="form-control" type="number" min="0" step="0.01" name="amount_loan[]" value="{{ $loan->amount_per_month }}" required placeholder=" " />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" onclick="remove(this)" style="margin-top: 3px">Del</button>
                        </div>
                    </div>
                @endforeach
            @endif
            
        @endif
    @else
        <div class="row mt-2 {{ $no_data }}">
            <div class="col-md-12">
                No data Found
            </div>
        </div>
    @endif
</div>

<script>
    function remove(input) {
        input.parentNode.parentElement.remove()
    }
</script>