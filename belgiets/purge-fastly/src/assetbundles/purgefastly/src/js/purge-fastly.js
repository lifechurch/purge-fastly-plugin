$(document).ready(function () {
  let $fieldsWrapper = $('.fastly-sids-wrapper')
  let fieldExample = $fieldsWrapper.attr('data-field')

  $('#settings-add-sid').on('click', function() {
    let index = $('.settings-field', $fieldsWrapper).length
    let fieldHtml = fieldExample.replace(/{{}}/g, index)
    fieldHtml = fieldHtml.replace(/={}=/g, index + 1)

    $fieldsWrapper.append(fieldHtml)
  })

  $fieldsWrapper.on('click', '.remove-settings', function() {
    let removeIndex = $(this).attr('data-remove')

    $(`.settings-field.${removeIndex}`).remove()
  })
})


