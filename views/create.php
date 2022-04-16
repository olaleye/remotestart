<h3><?php echo $title ?></h3>
<hr>

<form action="" method="post">
    <div class="mb-3">
        <label for="hotelName" class="form-label">Hotel Name</label>
        <input type="text" class="form-control" id="hotelName" name="hotel">
        <div id="hotelName" class="form-text">Please enter a hotel name.</div>
    </div>

    <div class="mb-3">
        <label for="floor" class="form-label">Floor</label>
        <input type="number" class="form-control" id="floor" name="floor">
        <div id="emailHelp" class="form-text">Please enter the floor number.</div>
    </div>

    <div class="mb-3">
        <label for="roomNumber" class="form-label">Room Number</label>
        <input type="number" class="form-control" id="roomNumber" name="room">
        <div id="emailHelp" class="form-text">Please enter the room number.</div>
    </div>

    <div class="mb-3">
        <label for="roomPrice" class="form-label">Room Price</label>
        <input type="number" step=".01" class="form-control" id="roomPrice" name="price">
        <div id="emailHelp" class="form-text">Please enter the room price.</div>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="available">
        <label class="form-check-label" for="exampleCheck1">Available</label>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
