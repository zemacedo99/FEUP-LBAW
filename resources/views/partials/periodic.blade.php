<input type="hidden" id="periodic" name="periodic" value="SingleBuy">

                <div class="col-12 col-lg-12 order-2">
                    <div class="row">

                        <div class="col"></div>

                        <div class="col-12 col-lg-12">

                            <div class="row">
                                <h3 style='text-align:left;border-bottom:2px solid black;'>Periodic Buys <button type="button" class="simpleicon">history</button></h3>
                            </div>

                            <div class="row mb-3"></div>

                            <div class="row">

                                <ul class="nav nav-pills mb-3 d-flex justify-content-evenly" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <label data-bs-toggle="pill" data-bs-target="#pills-once"  class="periodic" id="SingleBuy" >Once</label>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <label data-bs-toggle="pill" data-bs-target="#pills-daily" class="periodic" id="Day" >Daily</label>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <label data-bs-toggle="pill" data-bs-target="#pills-weekly" class="periodic" id="Week" >Weekly</label>
                                    </li>
                                    <li class="nav-item" role="presentation">  
                                        <label data-bs-toggle="pill" data-bs-target="#pills-monthly" class="periodic" id="Month" >Monthly</label>
                                    </li>
                                </ul>

                                <div class="row mb-3"></div>

                                <div class="tab-content" >
                                    <div class="tab-pane fade text-center" id="pills-once" role="tabpanel" >One time purchase</div>
                                    <div class="tab-pane fade text-center" id="pills-daily" role="tabpanel">Daily purchase the products in this cart</div>
                                    <div class="tab-pane fade text-center" id="pills-weekly" role="tabpanel">
                                        <input type="radio" id="monday" name="gender" value="monday" class="d-none">
                                        <label for="monday">Monday</label><br>
                                        <input type="radio" id="tuesday" name="gender" value="tuesday" class="d-none">
                                        <label for="tuesday">Tuesday</label><br>
                                        <input type="radio" id="wednesday" name="gender" value="wednesday" class="d-none">
                                        <label for="wednesday">Wednesday</label><br>
                                        <input type="radio" id="thursday" name="gender" value="thursday" class="d-none">
                                        <label for="thursday">Thursday</label><br>
                                        <input type="radio" id="friday" name="gender" value="friday" class="d-none">
                                        <label for="friday">Friday</label><br>
                                        <input type="radio" id="saturday" name="gender" value="saturday" class="d-none">
                                        <label for="saturday">Saturday</label><br>
                                        <input type="radio" id="sunday" name="gender" value="sunday" class="d-none">
                                        <label for="sunday">Sunday</label><br>
                                    </div>
                                    <div class="tab-pane fade text-center" id="pills-monthly" role="tabpanel">
                                        <label for="festa">Choose the day of the next delivery <br> All of the next deliveries will occur on the same day monthly</label>
                                        <div class="col-12 d-flex justify-content-center mt-2">
                                            <input type="date" id="festa" name="festa" min="<?= date('Y-m-d') ?>" max="<?php $dt2 = new DateTime("+1 month");
                                                                                                                        $date = $dt2->format("Y-m-d");
                                                                                                                        echo $date ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col"></div>
                        <div class="row m-3"></div>
                    </div>
                </div>