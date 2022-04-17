<h3><?php echo $title ?></h3>
<hr>

<?php if(isset($errors))
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }
?>

<div class="row">
    <form action="/search" method="post">

        <div class="mb-3">
            <label for="numberOfRooms" class="form-label">Number of rooms required</label>
            <input type="number" class="form-control" id="numberOfRooms" name="number_of_rooms">
            <div id="emailHelp" class="form-text">Please enter the number rooms required.</div>
        </div>

        <div class="mb-3">
            <label for="minimumBudget" class="form-label">Minimum budget</label>
            <input type="number" step=".01" class="form-control" id="minimumBudget" name="minimum_budget">
            <div id="emailHelp" class="form-text">Please enter your minimum budget.</div>
        </div>

        <div class="mb-3">
            <label for="MaximumBudget" class="form-label">Maximum budget</label>
            <input type="number" step=".01" class="form-control" id="MaximumBudget" name="maximum_budget">
            <div id="emailHelp" class="form-text">Please enter your maximum budget.</div>
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<div class="row mt-5">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Available</th>
            <th scope="col">Floor</th>
            <th scope="col">Room No</th>
            <th scope="col">Per Room Price</th>
        </tr>
        </thead>
        <tbody>
            <?php
                if(isset($hotels)){
                    foreach ($hotels as $hotel){
                        echo '<tr>';
                            echo "<td> {$hotel->hotel_name} </td>";
                            echo "<td> True </td>";
                            echo "<td> {$hotel->floor} </td>";
                            echo "<td> {$hotel->room_number} </td>";
                            echo "<td>" . number_format($hotel->room_price, 2) . "</td>";
                        echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
</div>
