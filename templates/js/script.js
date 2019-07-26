window.onload = function() {
  // Show and Hide Password in password fields
  $("#showPwdBtn").click(function(e) {
    e.preventDefault();
    if ($("#showPwdIcon").hasClass("fa-eye")) {
      $("#pwdField")
        .attr("type", "text")
        .focus();
      $("#showPwdBtn").attr("title", "Hide Password");
      $("#showPwdIcon")
        .removeClass("fa-eye")
        .addClass("fa-eye-slash");
    } else {
      $("#pwdField")
        .attr("type", "password")
        .focus();
      $("#showPwdBtn").attr("title", "Show Password");
      $("#showPwdIcon")
        .removeClass("fa-eye-slash")
        .addClass("fa-eye");
    }
  });

  // Get form data as JSON
  function getFormDataAsJSON(form) {
    let formData = form.serializeArray();
    let data = {};
    formData.forEach(inp => {
      data[inp.name] = inp.value;
    });
    return data;
  }

  // Customer Registration
  $("#custRegForm").submit(function(e) {
    e.preventDefault();
    let custData = getFormDataAsJSON($(this));
    console.log(custData);
    $.post(
      "/api/customer/register",
      custData,
      function(res) {
        if (res.email) {
          $("#regError")
            .text(res.email)
            .fadeIn("fast");
          return;
        } else if (!res) {
          $("#regError")
            .text("Unable to register. please try again.")
            .fadeIn("fast");
          return;
        }
        if (res) {
          window.location = "/login";
        }
      },
      "json"
    );
  });

  // Restaurant Registration
  $("#restRegForm").submit(function(e) {
    e.preventDefault();
    let restData = getFormDataAsJSON($(this));
    $.post(
      "/api/restaurant/register",
      restData,
      function(res) {
        if (res.email) {
          $("#regError")
            .text(res.email)
            .fadeIn("fast");
          return;
        } else if (!res) {
          $("#regError")
            .text("Unable to register. please try again.")
            .fadeIn("fast");
          return;
        }
        if (res) {
          window.location = "/login";
        }
      },
      "json"
    );
  });

  // Login
  $("#loginForm").submit(function(e) {
    e.preventDefault();
    let loginData = getFormDataAsJSON($(this));
    $.post(
      "/api/login",
      loginData,
      function(res) {
        if (res == true) {
          window.location = "/";
        } else {
          $("#regError").fadeIn("fast");
        }
      },
      "json"
    );
  });

  // Set restaurant id to the hidden field in the add-menu modal
  $("#addMenuModal").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var restId = button.data("restid");
    var modal = $(this);
    $("input#itemRestId").val(restId);
  });

  // Add Menu Item
  $("#addMenuForm").submit(function(e) {
    e.preventDefault();
    let menuData = getFormDataAsJSON($(this));
    if (menuData.veg) {
      menuData.veg = 0;
    } else {
      menuData.veg = 1;
    }
    $.post(
      "/api/restaurant/menu",
      menuData,
      function(res) {
        if (res) {
          window.location = "/menu";
        } else {
          $("#addMenuError").fadeIn("fast");
        }
      },
      "json"
    );
  });

  // Remove menu Item
  $(".removeMenu").click(function(e) {
    e.preventDefault();
    let id = $(this).attr("id");
    $.ajax({
      url: `/api/restaurant/menu/${id}`,
      type: "DELETE",
      success: function(res) {
        if (res) {
          window.location = "/menu";
        } else {
          alert("Unable to remove item! Please try again.");
        }
      },
      dataType: "json"
    });
  });

  // Order an item
  $(".orderBtn").click(function(e) {
    e.preventDefault();
    let menuId = $(this).attr("data-menuid");
    let restId = $(this).attr("data-restid");
    $.post(
      `/api/order/${restId}/${menuId}`,
      function(res) {
        if (res) {
          window.location = "/orders";
        } else {
          window.location = "/login";
        }
      },
      "json"
    );
  });
};
