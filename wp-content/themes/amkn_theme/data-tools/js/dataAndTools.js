/* 
 * Copyright (C) 2014 CRSANCHEZ
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$("#embed").css('background', '#FFF');

//$(".category-btn").click(function() {
//  $(this).addClass('selected').siblings().removeClass('selected');
//});
function selectAll(btn) {
  if (btn.checked) { // check select status
    $('.checkall').each(function() { //loop through each checkbox
      this.checked = true;  //select all checkboxes with class "checkbox1" 
    });
  } else {
    $('.checkall').each(function() { //loop through each checkbox
      this.checked = false; //deselect all checkboxes with class "checkbox1"  
    });
  }
}

function validSelect(check) {
  var sel = true;
  if (!check.checked) {
    $('#selectall').attr('checked', false);
  } else {
    $('.checkall').each(function() { //loop through each checkbox
      if (!this.checked)
        sel = false;  //select all checkboxes with class "checkbox1" 
    });
    if (sel) {
      $('#selectall').attr('checked', true);
    }
  }
}

function categoryChosen(id, form, page) {
  page = page || 1;
  $.ajax({
    url: "result.php?" + form,
    type: "POST",
    data: {category: id, page:page},
    success: function(result) {
      $("#loading").show();
      $("#result").hide();
      $("#result").html(result);
    },
    complete: function() {
      $("#loading").fadeOut('slow');
      $("#result").show();
    }
  });
  document.location.hash = "category="+id+((form)?"/"+form:"");
}

function deliverableChosen(id) {
  $.ajax({
    url: "detail.php",
    type: "POST",
    data: {deliverable: id},
    success: function(result) {
      $("#result").hide();
      $("#detail").html(result);
    }
  })
}

function serachDeliverable(key, e) {
  if (e.which == 13 || e.keyCode == 13 || e == true) {
    $.ajax({
      url: "searchResult.php",
      type: "POST",
      data: {key: key},
      success: function(result) {
        $("#loading").show();
        $("#result").hide();
        $("#result").html(result);
      },
      complete: function() {
        $(".category-btn").removeClass('selected');
        $("#detail").html('');
        $("#loading").fadeOut('slow');
        $("#result").show();
      }
    });
  }
}

function initialState(anchor) {
  if (anchor != '') {
    var form = '';
    var page = 1 ;
    var params = unescape(anchor).split("/");
    var cat = params[0].split("=")[1];
    if (typeof params[1] !== "undefined") {
      form = params[1];
    }
    if (typeof params[2] !== "undefined") {
      initPage = false;
      page = params[2].split("=")[1];
    }
//    alert(cat+' '+params[1]);
    categoryChosen(cat, form, page);
    $('#cat'+cat).addClass('selected').siblings().removeClass('selected');
    $('#result').show();
    $('#detail').html('');
    $('.searchbar').val('');
//    request_page(page, form);
  }
}
