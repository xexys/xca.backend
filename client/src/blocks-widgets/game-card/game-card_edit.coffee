GameCardWidget = require('./game-card')

class GameCardEditWidget extends GameCardWidget


  events:
    'click .game-card_platform-info-btn_add': '_addPlatformInfo'
    'click .game-card_platform-info-btn_remove': '_removePlatformInfo'


  _addPlatformInfo: (e) ->
    e.preventDefault()

    template = @_getPlatformInfoTemplate()

    $platformInfo = @_getClosestPlatformInfo(e.target)
    $platformInfo.after($(template))

    @_toggleRemoveBtn()


  _removePlatformInfo: (e) ->
    e.preventDefault()

    $platformInfo = @_getClosestPlatformInfo(e.target)
    $platformInfo.remove()

    @_toggleRemoveBtn()


  _toggleRemoveBtn: ->
    $buttons = @$('.game-card_platform-info-btn_remove')
    hidden = $buttons.length == 1
    $buttons.toggleClass('game-card_platform-info-btn_hidden', hidden)


  _getPlatformInfoTemplate: ->
    @_num = @_num || @_getAllPlatformInfo().length
    template = $('#game-card_platform-info-template').html()
    template.replace(/xxxxx/g, @_num++)
    return template;


  _getAllPlatformInfo: ->
    return @$('.game-card_platform-info')


  _getClosestPlatformInfo: (selector) ->
    return @$(selector).closest('.game-card_platform-info')


module.exports = GameCardEditWidget