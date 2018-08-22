<?php require_once 'partials/head.php'; ?>
<div class="container-fluid text-center">
    <form action="game.php" method="POST" id="start-game" class="text-center col-sm-2 offset-sm-5">
        <div class="form-group">
            <label for="width">Board width:</label>
            <input type="text" class="form-control" id="width" name="width">
        </div>
        <div class="form-group">
            <label for="height">Board height:</label>
            <input type="text" class="form-control" id="height" name="height">
        </div>
        <div class="form-group">
            <label for="random_cells">Live cells number:</label>
            <input type="text" class="form-control" id="random_cells" name="random_cells">
        </div>
        <div class="errors-wrapper"></div>
        <button type="submit" class="btn btn-success col-sm-12">Start new game</button>
    </form>

    <form action="game.php" method="POST" class="text-center col-sm-12" id="continue-game">
        <div class="game-board"></div>
        <input type="hidden" name="width" value="0">
        <input type="hidden" name="height" value="0">
    </form>
</div>
<?php require_once 'partials/footer.php'; ?>

