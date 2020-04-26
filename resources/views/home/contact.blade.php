@extends('layout.frontend-layout')
@section('title','Contact Us')
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{route('index')}}">home</a></li>
                            <li>contact us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--contact area start-->
    <div class="contact_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="contact_message content">
                        <h3>contact us</h3>
                        <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum
                            est notare quam littera gothica, quam nunc putamus parum claram anteposuerit litterarum
                            formas human. qui sequitur mutationem consuetudium lectorum. Mirum est notare quam</p>
                        <ul>
                            <li><i class="fa fa-fax"></i> Address : No 40 Sufi saint Data Ganj Baksh (Ali Hujwiri)
                                lahore.
                            </li>
                            <li><i class="fa fa-phone"></i> <a href="#">Infor@bilalganj.com</a></li>
                            <li><i class="fa fa-envelope-o"></i> 0(1234) 567 890</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="contact_message form account_form">
                        <h3>Tell us your project</h3>
                        <form id="contact-form" method="post" action="{{route('saveContactUsInfo')}}" class="needs-validation" novalidate>
                            @csrf
                            <p>
                            <div>
                                <label> Your Name (required)</label>
                                <input name="name" placeholder="Name" type="text" class="form-control" required>
                                @include('error.error', ['filed' => 'name'])
                                <div class="invalid-feedback">
                                    Name Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label> Your Email (required)</label>
                                <input name="email" placeholder="Email" type="email" class="form-control" required>
                                 @include('error.error', ['filed' => 'email'])
                                <div class="invalid-feedback">
                                    Valid Email Required
                                </div>
                            </div>
                            </p>
                            <p>
                            <div>
                                <label> Subject</label>
                                <input name="subject" placeholder="Subject" type="text" class="form-control" required>
                                @include('error.error', ['filed' => 'subject'])
                                <div class="invalid-feedback">
                                    Subject Required
                                </div>
                            </div>
                            </p>
                            <div class="contact_textarea">
                                <label> Your Message</label>
                                <textarea placeholder="Message" name="message" class="form-control2 form-control"
                                          required></textarea>
                                @include('error.error', ['filed' => 'message'])
                                <div class="invalid-feedback">
                                    Message Required
                                </div>
                            </div>
                            <div class="login_submit">
                                <button type="submit"> Send</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--contact area end-->
@endsection