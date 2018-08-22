var $game_board = $('.game-board');
var $continue_game_form = $('#continue-game');
var $errors_wrapper = $('.errors-wrapper')

$('form#start-game').on('submit', function(e){
    e.preventDefault();

    var $this = $(this);

    $.post({
        url: $this.attr('action'),
        data: $this.serialize(),
        success: function(response){
            $errors_wrapper.empty();

            $game_board.html(response.cells);
            $continue_game_form.find('input[name=width]').val(response.board.width);
            $continue_game_form.find('input[name=height]').val(response.board.height);
        },
        error: function (errors) {
            handleErrors(errors.responseJSON);
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
            $errors_wrapper.empty();

            $game_board.html(response.cells);
        },
        error: function (errors) {
            handleErrors(errors.responseJSON);
        }
    });
});

function handleErrors(errors)
{
    $errors_wrapper.empty();

    if (typeof errors !== 'undefined') {
        var index = 0;

        for (index in errors) {
            $errors_wrapper.append('<p class="alert alert-danger">'+errors[index]+'</p>');
        }
    }
}