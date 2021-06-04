<div class="modal fade" id="periodicEdit" tabindex="-1" aria-labelledby="periodicEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodicEditLabel">Periodic Buy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-pills mb-3 d-flex justify-content-evenly" role="tablist">
                    <li class="nav-item" role="presentation">
                        <label data-bs-toggle="pill" data-bs-target="#pills-daily">Daily</label>
                    </li>
                    <li class="nav-item" role="presentation">
                        <label data-bs-toggle="pill" data-bs-target="#pills-weekly">Weekly</label>
                    </li>
                    <li class="nav-item" role="presentation">
                        <label data-bs-toggle="pill" data-bs-target="#pills-monthly">Monthly</label>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-daily" role="tabpanel" >Set to receive this product daily.</div>
                    <div class="tab-pane fade text-center" id="pills-weekly" role="tabpanel" >
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
                    <div class="tab-pane fade" id="pills-monthly" role="tabpanel" >
                        <label for="festa">Choose the day of the next delivery. All of the next deliveries will occur on the same day monthly</label>
                        <div class="col-12 d-flex justify-content-center mt-2">
                            <input type="date" id="festa" name="festa" min="<?= date('Y-m-d') ?>" max="<?php $dt2 = new DateTime("+1 month");
                                                                                                                            $date = $dt2->format("Y-m-d");
                                                                                                                            echo $date ?>" required>
                        </div>

                    </div>
                </div>


                <!-- <div class="row">
                    <div class="col">
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Daily</label><br>
                    </div>
                    <div class="col">
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Weekly</label><br>
                    </div>
                    <div class="col">
                        <input type="radio" id="other" name="gender" value="other">
                        <label for="other">Monthly</label>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>