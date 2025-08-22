@extends('admin.layout.contact')


@section('page', 'page title')


@section('maincontact')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ url('/') }}/public/admin/css/style.css">

    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <section id="data_section" class="data-section-max">
                <div id="dashboard-page">

                    <section id="add_data">
                        <h2>
                            Add User
                        </h2>

                        <div id="form_container">

                            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-input">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                        required />
                                </div>

                                <!-- Email -->
                                <div class="form-input">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                        required />
                                </div>

                                <!-- Phone -->
                                <div class="form-input">
                                    <label for="phone" class="form-label">Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control"
                                        placeholder="Enter Phone Number" required />
                                </div>

                                <!-- Gender -->
                                <div class="form-input">
                                    <label for="">Gender : <span class="error">*</span></label>
                                    <select name="gender" class="data-select">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <!-- DOB -->
                                <div class="form-input">
                                    <label for="dob" class="form-label">Date of Birth <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="dob" class="form-control" required />
                                </div>

                                <!-- City -->
                                <div class="form-input">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" placeholder="Enter City"
                                        required />
                                </div>

                                <!-- State -->
                                <div class="form-input">
                                    <label for="state" class="form-label">State <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control" placeholder="Enter State"
                                        required />
                                </div>

                                <!-- Country -->
                                <div class="form-input">
                                    <label for="country" class="form-label">Country <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control" placeholder="Enter Country"
                                        required />
                                </div>

                                <!-- Address -->
                                <div class="form-input">
                                    <label for="address" class="form-label">Address <span
                                            class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" placeholder="Enter Address" rows="2" required></textarea>
                                </div>
                                <div class="form-input">
                                    <label for="sallery" class="form-label">Sallery <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="sallery" class="form-control" placeholder="Enter Country"
                                        required />
                                </div>

                                <!-- Profile Image -->
                                <div class="form-input">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control" />
                                </div>

                                <!-- Password -->
                                <div class="form-input">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter Password" required />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-input">
                                    <label for="confirm_password" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" class="form-control"
                                        placeholder="Re-enter Password" required />
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex " style="margin-left: 400px">
                                    <button type="submit" class="btn btn-success px-4">Save</button>
                                    <button type="reset" class="btn btn-danger px-4">Exit</button>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                            </form>
                        </div>
                    </section>


                </div>




            </section>


    </section>




    </div>
@include('tostar_msg.tostar');


@endsection
