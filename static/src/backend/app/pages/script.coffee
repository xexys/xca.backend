#require('backend/blocks/foo-bar')
#require('backend/blocks/foo-bar_baz')
#require('backend/blocks/foo-bar/item')
#require('backend/blocks/foo-bar/item_active')

BasePage = require('backend/app/base')

$ ->
  (new BasePage).start()
