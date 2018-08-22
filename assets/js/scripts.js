var $game_board = $('.game-board');
var $continue_game_form = $('#continue-game');


$('form#start-game').on('submit', function(e){
    e.preventDefault();

    var $this = $(this);

    $.post({
        url: $this.attr('action'),
        data: $this.serialize(),
        success: function(response){
            $game_board.html(response.cells);
            $continue_game_form.find('input[name=width]').val(response.board.width);
            $continue_game_form.find('input[name=height]').val(response.board.height);
        }
    });
});

$('form#continue-game').on('submit', function(e){
    e.preventDefault();

    var $this = $(this);

    $.post({
        url: $this.attr('action'),
        data: $this.serialize(),
        success: function(response){
            $game_board.html(response.cells);
        }
    });
});
