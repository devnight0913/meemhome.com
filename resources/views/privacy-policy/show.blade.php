@extends('layouts.app')
@section('title', 'Privacy policy')

@section('header')
    <div id="pagetitle" class="bg-primary position-relative">
        <div id="particals"></div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="page-title-inner">
                <div class="image-overlay"></div>
                <div class="page-title-holder">
                    <div class="title-main">Privacy policy</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div>
        <p></p><strong>SECTION 1 - WHAT DO WE DO WITH YOUR INFORMATION?</strong>
        <p></p>
        <p></p>
        <p></p>When you order something from our website and apps, as part of the buying and selling process, we collect the
        personal information you give us such as your name, address and email address.
        <p></p>
        <p></p>
        <p></p>When you browse our online ordering platform, we also automatically receive your computer’s internet protocol
        (IP) address in order to provide us with information that helps us learn about your browser and operating system.
        <p></p>
        <p></p>
        <p></p>Email marketing (if applicable): With your permission, we may send you emails about our new features, new
        products and other updates.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 2 - CONSENT
            <p></p>
        </strong>
        <p></p>
        <p></p>When you provide us with personal information to complete a transaction, verify your credit card, place an
        order, arrange for a delivery, we imply that you consent to our collecting it and using it for that specific reason
        only.
        <p></p>
        <p></p>
        <p></p>If we ask for your personal information for a secondary reason, like marketing, we will either ask you
        directly for your expressed consent, or provide you with an opportunity to say no.
        <p></p>
        <p></p>
        <p></p>If after you opt-in, you change your mind, you may withdraw your consent for us to contact you, for the
        continued collection, use or disclosure of your information, at anytime, by contacting us Through our communicated
        email and phone numbers on this site or app.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 3 - DISCLOSURE
            <p></p>
        </strong>
        <p></p>
        <p></p>We may disclose your personal information if we are required by law to do so or if you violate our Terms of
        Service.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 4 - HOSTED DATA<p></p></strong>
        <p></p>
        <p></p>Our store is hosted on spoonstream. They provide us with the online e-commerce platform that allows us to
        sell our products and services to you.
        <p></p>
        <p></p>
        <p></p>Your data is stored through spoonstream’s data storage, databases and the general spoonstream application.
        They store your data on a secure server behind a firewall.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 5 - PAYMENT DATA</strong>
        <p></p>
        <p></p>
        <p></p>If you choose a direct payment gateway to complete your purchase, then we store your credit card data safely.
        It is encrypted through the Payment Card Industry Data Security Standard (PCI-DSS). Your purchase transaction data
        is stored only as long as is necessary to complete your purchase transaction. After that is complete, your purchase
        transaction information is deleted.
        <p></p>
        <p></p>
        <p></p>All direct payment gateways adhere to the standards set by PCI-DSS as managed by the PCI Security Standards
        Council, which is a joint effort of brands like Visa, MasterCard, American Express and Discover.
        <p></p>
        <p></p>
        <p></p>PCI-DSS requirements help ensure the secure handling of credit card information by our store and its service
        providers.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 6 - SECURITY
            <p></p>
        </strong>
        <p></p>
        <p></p>To protect your personal information, we take reasonable precautions and follow industry best practices to
        make sure it is not inappropriately lost, misused, accessed, disclosed, altered or destroyed.
        <p></p>
        <p></p>
        <p></p>The information is encrypted using secure socket layer technology (SSL) and stored with a AES-256 encryption.
        &nbsp;Although no method of transmission over the Internet or electronic storage is 100% secure, we follow all
        PCI-DSS requirements and implement additional generally accepted industry standards.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 7 - AGE OF CONSENT
            <p></p>
        </strong>
        <p></p>
        <p></p>By using this site, you represent that you are at least the age of majority in your state or province of
        residence, or that you are the age of majority in your state or province of residence and you have given us your
        consent to allow any of your minor dependents to use this site.
        <p></p>
        <p></p>
        <p></p><strong>SECTION 8 - CHANGES TO THIS PRIVACY POLICY
            <p></p>
        </strong>
        <p></p>
        <p></p>We reserve the right to modify this privacy policy at any time, so please review it frequently. Changes and
        clarifications will take effect immediately upon their posting on the website. If we make material changes to this
        policy, we will notify you here that it has been updated, so that you are aware of what information we collect, how
        we use it, and under what circumstances, if any, we use and/or disclose it.
        <p></p>
        <div></div>
    </div>
@endsection
@push('script')
    <script>
        particlesJS.load('particals', '/particles.json');
    </script>
@endpush
