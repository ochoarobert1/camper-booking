jQuery(document).on("ready", function () {
  jQuery(".camper-booking-option-item").on("click", function () {
    if (jQuery(this).hasClass("active")) {
      return;
    }

    let selectedPanel = jQuery(this).data("panel");

    jQuery(".camper-booking-option-item").removeClass("active");
    jQuery(".camper-booking-option-panel").addClass("hidden-tab");

    jQuery(this).addClass("active");
    jQuery("#" + selectedPanel).removeClass("hidden-tab");
  });

  jQuery("#saveGeneralSettings").on("click", function (e) {
    e.preventDefault();
    let form = jQuery("#generalSettingsForm");
    let data = form.serialize();

    jQuery.ajax({
      url: camperBooking.ajaxUrl,
      type: "POST",
      data: {
        action: "camper_booking_save_general_options",
        data: data,
      },
      success: function (response) {
        if (response.success) {
          alert("Settings saved successfully!");
        } else {
          alert("Error saving settings: " + response.data.message);
        }
      },
      error: function () {
        alert("An error occurred while saving settings.");
      },
    });
  });

  jQuery("#savePublicSettings").on("click", function (e) {
    e.preventDefault();
    let form = jQuery("#publicSettingsForm");
    let data = form.serialize();

    jQuery.ajax({
      url: camperBooking.ajaxUrl,
      type: "POST",
      data: {
        action: "camper_booking_save_public_options",
        data: data,
      },
      success: function (response) {
        if (response.success) {
          alert("Settings saved successfully!");
        } else {
          alert("Error saving public settings: " + response.data.message);
        }
      },
      error: function () {
        alert("An error occurred while saving public settings.");
      },
    });
  });

  // Media uploader handler
  jQuery(document).on("click", ".upload-icon", function (e) {
    e.preventDefault();
    var button = jQuery(this);
    var iconUrl = button.siblings(".icon-url");
    var preview = button.siblings(".icon-preview");

    var frame = wp.media({
      title: "Select or Upload Icon",
      button: {
        text: "Use this icon",
      },
      multiple: false,
    });

    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      iconUrl.val(attachment.url);
      preview.attr("src", attachment.url).show();
    });

    frame.open();
  });

  // Add feature row
  jQuery("#add_feature").on("click", function () {
    var template = document.getElementById("feature-row-template");
    var clone = template.content.cloneNode(true);
    jQuery(".features-container").append(clone);
  });

  // Remove feature row
  jQuery(document).on("click", ".remove-feature", function () {
    jQuery(this).closest(".feature-row").remove();
  });
});
