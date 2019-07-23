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
        if (res) {
          window.location = "/orders";
        } else {
          $("#regError").fadeIn("fast");
        }
      },
      "json"
    );
  });
};
