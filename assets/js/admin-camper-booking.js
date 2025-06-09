jQuery(document).ready(function () {
  let calendarEl = document.getElementById("camperBookingCalendar"),
    camperBookingFullCalendar = document.getElementById(
      "camperBookingFullCalendar"
    ),
    startDate = formatDateToDateTime(jQuery("#startDate").val()),
    endDate = formatDateToDateTime(jQuery("#endDate").val());

  function formatDateToDateTime(dateStr) {
    if (!dateStr) return "";
    try {
      const parts = dateStr.split("/");
      if (parts.length !== 3) return "";
      return `${parts[2]}-${parts[1]}-${parts[0]}T00:00:00`;
    } catch (e) {
      console.error("Date format error:", e);
      return "";
    }
  }

  if (calendarEl) {
    if (startDate && endDate) {
      const initialDateOnly = startDate ? startDate.split("T")[0] : "";
      var singleBookingCalendar = new FullCalendar.Calendar(calendarEl, {
        locale: "en",
        initialDate: initialDateOnly,
        initialView: "dayGridMonth",
        events: [
          {
            title: "Selected Booking",
            start: startDate,
            end: endDate,
            display: "background",
            color: "#A8DADC",
          },
        ],
      });
      singleBookingCalendar.render();
    }
  }

  if (camperBookingFullCalendar) {
    var bookingCalendar = new FullCalendar.Calendar(camperBookingFullCalendar, {
      locale: "en",
      initialView: "dayGridMonth",
      events: function (info, successCallback, failureCallback) {
        console.log(
          "Fetching events for date range:",
          info.startStr,
          "to",
          info.endStr
        );
        jQuery.ajax({
          url: camperBooking.ajaxUrl,
          type: "POST",
          data: {
            action: "get_camper_bookings",
          },
          success: function (response) {
            console.log("AJAX response:", response);
            if (response.success && response.data && response.data.length > 0) {
              // Format the data to match FullCalendar's expected format
              const formattedEvents = response.data.map((event) => {
                // Handle both array and string formats for start/end dates
                const startDate = Array.isArray(event.start)
                  ? event.start[0]
                  : event.start;
                const endDate = Array.isArray(event.end)
                  ? event.end[0]
                  : event.end;

                console.log("Processing event:", event);
                console.log("Start date:", startDate, "End date:", endDate);

                // Decode HTML entities in the title
                const tempElement = document.createElement("div");
                tempElement.innerHTML = event.title;
                const decodedTitle = tempElement.textContent;

                const formattedStart = formatDateToDateTime(startDate);
                const formattedEnd = formatDateToDateTime(endDate);
                console.log("Formatted dates:", formattedStart, formattedEnd);

                return {
                  title: decodedTitle,
                  start: formattedStart,
                  end: formattedEnd,
                  url: event.post_id
                    ? `${camperBooking.adminUrl}post.php?post=${event.post_id}&action=edit`
                    : null,
                  className: event.post_id ? "has-link" : "",
                };
              });
              console.log("Formatted events:", formattedEvents);
              successCallback(formattedEvents);
            } else {
              console.warn("No events found or invalid response:", response);
              successCallback([]); // Send empty array instead of failing
            }
          },
          error: function (error) {
            console.error("AJAX error:", error);
            failureCallback("Error connecting to server");
          },
        });
      },
      eventColor: "#A8DADC",
      textColor: "#000000",
    });
    bookingCalendar.render();
  }

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
