@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')
        <link rel="stylesheet" href="{{ url('/') }}/public/admin/css/style.css">



    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <section id="add_data">
                <h2>
                    Profile
                </h2>

                <div id="form_container">

                    <form action="{{ route('admin_profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="inp" value="{{ $admin_profile->id ?? '' }}" name="id" />

                        <!-- Name -->
                        <div class="form-input">
                            <label for="">Name : <span class="error">*</span></label>
                            <input type="text" class="inp" value="{{ $admin_profile->name ?? '' }}" name="name"
                                placeholder="Enter Name" />
                        </div>

                        <!-- Email -->
                        <div class="form-input">
                            <label for="">Email : <span class="error">*</span></label>
                            <input type="email" class="inp" value="{{ $admin_profile->email ?? '' }}" name="email"
                                placeholder="Enter Email" />
                        </div>

                        <!-- Phone -->
                        <div class="form-input">
                            <label for="">Phone : <span class="error">*</span></label>
                            <input type="tel" class="inp" value="{{ $admin_profile->phone ?? '' }}" name="phone"
                                placeholder="Enter Phone Number" />
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
