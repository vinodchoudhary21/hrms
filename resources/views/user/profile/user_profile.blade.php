@extends('user.layout.usercontact')


@section('page', 'page title')


@section('usercontact')



    <section id="data_section" class="data-section-max">
        <div id="dashboard-page">

            <section id="add_data">
                <h2>
                    Profile
                </h2>

                <div id="form_container">

                    <form action="{{ route('profile.update')}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="inp" value="{{ $profile->id ?? '' }}" name="id"
                             />

                        <!-- Name -->
                        <div class="form-input">
                            <label for="">Name : <span class="error">*</span></label>
                            <input type="text" class="inp" value="{{ $profile->name ?? '' }}" name="name"
                                placeholder="Enter Name" />
                        </div>

                        <!-- Email -->
                        <div class="form-input">
                            <label for="">Email : <span class="error">*</span></label>
                            <input type="email" class="inp" value="{{ $profile->email ?? '' }}" name="email"
                                placeholder="Enter Email" />
                        </div>

                        <!-- Phone -->
                        <div class="form-input">
                            <label for="">Phone : <span class="error">*</span></label>
                            <input type="tel" class="inp" value="{{ $profile->phone ?? '' }}" name="phone"
                                placeholder="Enter Phone Number" />
                        </div>

                        <!-- Gender -->
                        <div class="form-input">
                            <label for="">Gender : <span class="error">*</span></label>
                            <select name="gender" class="data-select" value="{{ $profile->gender ?? '' }}">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- DOB -->
                        <div class="form-input">
                            <label for="">Date of Birth : <span class="error">*</span></label>
                            <input type="date" class="inp" value="{{ $profile->dob ?? '' }}" name="dob" />
                        </div>

                        <!-- City -->
                        <div class="form-input">
                            <label for="">City : <span class="error">*</span></label>
                            <input type="text" class="inp" name="city" value="{{ $profile->city ?? '' }}"
                                placeholder="Enter City" />
                        </div>

                        <!-- State -->
                        <div class="form-input">
                            <label for="">State : <span class="error">*</span></label>
                            <input type="text" class="inp" name="state" value="{{ $profile->state ?? '' }}"
                                placeholder="Enter State" />
                        </div>

                        <!-- Country -->
                        <div class="form-input">
                            <label for="">Country : <span class="error">*</span></label>
                            <input type="text" class="inp" name="country" value="{{ $profile->country ?? '' }}"
                                placeholder="Enter Country" />
                        </div>

                        <!-- Address -->
                        <div class="form-input">
                            <label for="">Address : <span class="error">*</span></label>
                            <textarea name="address" class="data-text" value="" placeholder="Enter Address" rows="2">{{ $profile->address ?? '' }}</textarea>

                        </div>

                        <!-- Profile Image -->
                        <div class="form-input">
                            <label for="">Profile Image:</label>
                            <input type="file" class="inp" value="{{ $profile->profile_image ?? '' }}"
                                name="profile_image" />
                            <div class=""> <img class="profile_img"
                                    src="{{ url('public/storage/admin/form/profile_image/' . $profile->profile_image) }}"
                                    alt="" width="60px" height="60px"></div>
                        </div>

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



    @endsection
