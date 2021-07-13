<footer>
    <nav class="wadah_footer">
        @php
            $getTahun = date('Y');
        @endphp

        <center>
            <div class="row">
                <div class="row col-md-6 pt-3">
                    <div class="col-6 text-end pt-4 footer_style">
                        Contact Us:
                    </div>
                    <div class="col-6 text-start pt-1">
                        <table>
                            <tr>
                                {{-- <td>
                                    <form action="/send-email" method="POST" name="EmailForm" enctype="multipart/form-data" class="text-dark">
                                        @csrf
                                        <div class="form-group pb-2">
                                            <input name="user_name" type="text" class="shadow form-control @error('user_name') is-invalid @enderror" id="user_name" placeholder="Your Name" value="{{ old('user_name') }}">
                                            @error('user_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group pb-2">
                                            <input name="user_email" type="text" class="shadow form-control @error('user_email') is-invalid @enderror" id="user_name" placeholder="Email Address" value="{{ old('user_email') }}">
                                            @error('user_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group pb-2">
                                            <textarea name="user_message" id="address" class="shadow form-control @error('user_message') is-invalid @enderror" cols="30" rows="4" placeholder="Message">{{ old('user_message') }}</textarea>
                                            @error('user_message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group pb-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </td> --}}
                                <td>
                                    <a href="https://www.instagram.com/nirmala.pet/" target="_blank">
                                        <img src="{{asset('gambar/logo/instagram.png')}}" class="ContactUs" width="40px" alt="gambar1" title="@@nirmala.pet">
                                    </a>
                                </td>
                                {{-- <td>
                                    <img src="{{asset('gambar/logo/whatsapp.png')}}" class="ContactUs" width="40px" alt="gambar2" title="+62812345678910">
                                </td> --}}
                                <td>
                                    <a href="mailto:contact@nirmala.pet" target="_blank" class="text-light">
                                        <img src="{{asset('gambar/logo/email.png')}}" class="ContactUs" width="40px" alt="gambar3" title="contact@nirmala.pet">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 pt-3">
                    <p>
                        Copyright &copy; {{$getTahun}}: Nirmala. All Rights Reserved.
                    </p>
                </div>
            </div>
        </center>

        {{-- <br>
        <br>
        <div style="text-align: right; color: white">
            Build Laravel (v {{ Illuminate\Foundation\Application::VERSION }})
        </div> --}}
    </nav>
</footer>
