@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row mt-5 justify-content-center">
        <div class="col-2 justify-content-center"><img width="200" height="200" src="../images/icon.png" class="img-fluid" alt="Company Logotype"></div>
        <div class="col-5">
            <h2>MyGarden</h2>
            <p>
                Nowadays the existence of an online front for the traditional shops is of most importance in providing their sustainability and modernization.
            </p>
            <p>
                Themathics like biological and local products are on demand, therefore an application that easens the ordering of gardening and agricultural products is vital in the growth of local businesses and their expansion.
            </p>
            <p>
                With MyGarden, traditional shops will have the technological capabilities to survive against major supermarkets. 

            </p>
        </div>
    </div>
    <div class="row justify-content-center" id="FAQ">
        <div class="col-7 mt-5" style="border-bottom: 1px solid black">
            <h1>FAQ</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-7 mt-3">
            <h4>Is MyGarden trustworthy?</h4>
            <p>We proud ourselfs in having the highest of standards of ethic and quality!</p>
        </div>
        
        <div class="col-7 mt-3">
            <h4>How can we be sure that the products are fresh?</h4>
            <p>We apply our high standards to our suppliers. If they fall short, they are immediatly expelled from the platform.</p>
        </div>
        <div class="col-7 mt-3">
            <h4>Is my credit card safe with MyGarden?</h4>
            <p>At MyGarden, we use state of the art cryptography to make all your data safe!</p>
        </div>
        
    </div>

    <div class="row justify-content-center" id="contactUs">
        <div class="col-7 mt-5" style="border-bottom: 1px solid black">
            <h1>Contact Us</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-7 mt-3">
            <p class="text-center">mygardensupport@mygarden.pt</p>
            <p class="text-center">+351 255 420 690</p>
        </div>
        
    </div>

    <div class="row justify-content-center" id="findUs">
        <div class="col-7 mt-5" style="border-bottom: 1px solid black">
            <h1>Find Us</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-7 mt-3">
            <p class="text-center">Rua Dr. Roberto Frias, 4200-465 Porto</p>

        </div>
        
    </div>


</div>


@endsection
