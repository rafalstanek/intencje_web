$error_string = 'Brak połączenia z serwerem bazodanowym'

$(document).ready(function () {
  $date_intention = ''
  $('#check_intention_button').click(function () {
    var date = $('#date').val()

    if (date != '') {
      $.ajax({
        url: 'action.php',
        method: 'POST',
        data: {
          intentionData: date
        },
        success: function (data) {
          if (data.length != 0) {
            if (data == 'error') {
              alert('Wystąpił błąd w przetwarzaniu informacji')
              document.getElementById('intention_list').innerHTML = ''
              document.getElementById('textarea_intention_add').innerHTML = ''
            } else {
              var json = JSON.parse(data)
              $date_intention = date
              var selected_date = date.split('-')
              var text =
                '<center><u>Lista intencji na dzień ' +
                selected_date[2] +
                '.' +
                selected_date[1] +
                ':</u><br/>'
              if (json.length > 0) {
                text += '<b>' + json[0].dayName + '</b></center>'
                for (i = 0; i < json[0].intentionList.length; i++) {
                  var intention = ''
                  var hour = json[0].intentionList[i].date
                  hour = hour.substr(11, 5)
                  intention =
                    intention +
                    '<b>' +
                    hour +
                    '</b> ' +
                    json[0].intentionList[i].text +
                    '<br/>'
                  text += intention
                }
                document.getElementById('intention_list').innerHTML = text
              } else {
                text += '<center>BRAK</center>'
                document.getElementById('intention_list').innerHTML = text
              }

              document.getElementById('textarea_intention_add').innerHTML =
                '<hr/><label><b>Treść:</b></label><textarea rows="2" name="text_intention" placeholder="Wpisz treść intencji" id="text_intention" class="form-control">' +
                '</textarea><label><b>Data: </b>' +
                selected_date[2] +
                '.' +
                selected_date[1] +
                '.' +
                selected_date[0] +
                ' r.</label><br /><label><b>Godzina:</b></label><input type="time" name="time_intention" id="time_intention" class="form-control" /><br/>' +
                ' <button type="button" name="add_intention_button" id="add_intention_button" class="btn btn-info">Dodaj</button>'
            }
          } else {
            alert($error_string)
          }
        }
      })
    } else {
      document.getElementById('intention_list').innerHTML = ''
      document.getElementById('textarea_intention_add').innerHTML = ''
    }
  })
  $('#checkByDateModal').on('click', '#add_intention_button', function () {
    var text_intention = $('#text_intention').val()
    var time_intention = $('#time_intention').val()
    var date = $date_intention
    var datetime = date + 'T' + time_intention + ':00'

    if (time_intention != '') {
      $.ajax({
        url: 'add_intention.php',
        method: 'POST',
        data: {
          create_datetime: datetime,
          create_text: text_intention
        },
        success: function (data) {
          if (data.length != 0) {
            if (data == 'error') {
              alert('Wystąpił błąd w dodawaniu intencji')
            } else {
              location.reload()
              alert('Intencja została pomyślnie dodana!')
            }
          } else {
            alert($error_string)
          }
        }
      })
    } else {
      alert('Musisz podać godzinę')
    }
  })
  $('#change_pass_button').click(function () {
    var old_password = $('#old_password').val()
    var new_password = $('#new_password').val()
    var re_password = $('#re_password').val()

    if (old_password != '' && new_password != '' && re_password != '') {
      if (new_password == re_password) {
        $.ajax({
          url: 'change_password.php',
          method: 'POST',
          data: {
            old_password: old_password,
            new_password: new_password
          },
          success: function (data) {
            if (data.length != 0) {
              if (data == 'error') {
                alert('Wystąpił błąd w zmianie hasła')
              } else {
                var json = JSON.parse(data)
                if (json.id != null) {
                  location.reload()
                  alert('Hasło zostało zmienione pomyślnie')
                } else {
                  alert('Podano niepoprawne hasło!')
                }
              }
            } else {
              alert($error_string)
            }
          }
        })
      } else {
        alert('Nowe hasła muszą się zgadzać ze sobą')
      }
    } else {
      alert('Uzupełnij wszystkie pola!')
    }
  })
})
