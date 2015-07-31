MoviePageView = require('blocks-pages/movie');
MovieCardEdit = require('blocks-widgets/movie-card_edit');


class MovieCreatePageView extends MoviePageView

  initialize: ->
    new MovieCardEdit(el: '.movie-card_edit')


module.exports = MovieCreatePageView