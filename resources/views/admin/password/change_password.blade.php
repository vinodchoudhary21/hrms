@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')


    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <section id="add_data">
                <h2>
                    Change Password
                </h2>



                <div id="form_container">

                     <form action="{{ route('admin.changepass') }}" method="post">
                                            @csrf
                        <input type="hidden" class="inp" value="{{ $change_password->id }}" name="id" />

                        <!-- Name -->
                        <div class="form-input">
                            <label for="">Current Password : <span class="error">*</span></label>
                            <input type="hidden" class="form-control" name="email" value="{{ $change_password->email }}">
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter Current Password">
                                                    <span class="text-danger">
                                                    </span>
                                                    <span class="text-danger">
                                                        @error('password')
                                                        {{{$message}}}
                                                        @enderror
                                                    </span>
                        </div>

                        <!-- Email -->
                        <div class="form-input">
                            <label for="">New Password : <span class="error">*</span></label>
                            <input type="password" class="form-control" name="new_password"
                                                        placeholder="Enter New Password">
                                                    <span class="text-danger">
                                                    </span>
                                                    <span class="text-danger">
                                                        @error('new_password')
                                                        {{{$message}}}
                                                        @enderror
                                                    </span>
                        </div>

                        <!-- Phone -->
                        <div class="form-input">
                            <label for="">Re-enter New Password : <span class="error">*</span></label>
 <input type="password" class="form-control" name="conform_password"
                                                        placeholder="Enter Re-enter Password">
                                                        <span class="text-danger">
                                                            @error('conform_password')
                                                            {{{$message}}}
                                                            @enderror
                                                        </span>
                        </div>

                        <!-- Gender -->
                       

                        <!-- Submit Buttons -->
                        <div class="form-submit-container">
                            <button class="btn success" type="submit">Save</button>
                            <button class="btn danger" type="reset">Exit</button>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    </form>

                </div>
            </section>


        </div>

@include('tostar_msg.tostar');


    @endsection
