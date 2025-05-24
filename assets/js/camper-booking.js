document.addEventListener("DOMContentLoaded", function () {
  // Date picker localization
  const dateLang = {
    days: [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
    ],
    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    months: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ],
    monthsShort: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    today: "Today",
    clear: "Clear",
    dateFormat: "MM/dd/yyyy",
    timeFormat: "hh:ii aa",
    firstDay: 0,
  };

  // Handle step navigation
  function handleStepNavigation(e, direction) {
    e.preventDefault();
    const currentStep = parseInt(e.target.getAttribute("data-step"));
    const targetStep =
      direction === "next"
        ? currentStep + 1
        : currentStep > 1
        ? currentStep - 1
        : 1;

    console.log("currentStep", currentStep);
    console.log("targetStep", targetStep);

    const currentElement = document.querySelector(`#formStep${currentStep}`);
    const targetElement = document.querySelector(`#formStep${targetStep}`);
    setActiveBookingStep(targetStep - 1);

    if (targetElement) {
      currentElement.classList.add("hidden");
      targetElement.classList.remove("hidden");
    }
  }

  function setActiveBookingStep(stepIndex) {
    const steps = document.querySelectorAll(".camper-booking-step-item");
    steps.forEach((step, idx) => {
      if (idx === stepIndex) {
        step.classList.add("active");
      } else {
        step.classList.remove("active");
      }
    });
  }

  // Add event listeners to navigation buttons
  document.querySelectorAll("button.next-step").forEach((btn) => {
    btn.addEventListener("click", (e) => handleStepNavigation(e, "next"));
  });

  document.querySelectorAll("button.prev-step").forEach((btn) => {
    btn.addEventListener("click", (e) => handleStepNavigation(e, "prev"));
  });

  // Parse date string to Date object
  function parseDate(dateStr) {
    const parts = dateStr.trim().split("/");
    return new Date(
      parseInt(parts[2], 10),
      parseInt(parts[1], 10) - 1,
      parseInt(parts[0], 10)
    );
  }

  // Initialize date picker
  new AirDatepicker("#datePicker", {
    range: true,
    minDate: new Date(),
    //inline: true,
    locale: dateLang,
    dateFormat: "dd/MM/yyyy",
    multipleDatesSeparator: " - ",
    buttons: ["today", "clear"],
    onSelect: function (date) {
      if (!date) return;

      const dateSelected = document.querySelector(
        'input[name="datetimes"]'
      ).value;
      if (!dateSelected) return;

      const dateString = dateSelected.toString().split("-");
      if (dateString.length !== 2) {
        /*document.getElementById("dateSelected").innerHTML =
          translateArray["error_one_date"];*/
        return;
      }

      // Parse start and end dates
      const startDateStr = dateString[0].trim();
      const endDateStr = dateString[1].trim();
      const date1 = parseDate(startDateStr);
      const date2 = parseDate(endDateStr);

      // Update UI with selected dates
      //document.querySelector(".initial-day").innerHTML = startDateStr;
      //document.querySelector(".final-day").innerHTML = endDateStr;

      // Calculate and display duration
      const diffTime = Math.abs(date2 - date1);
      const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

      if (diffDays > 8) {
        /*document.getElementById("dateSelected").innerHTML =
          translateArray["max_days"];*/
      } else {
        /*document.getElementById("dateSelected").innerHTML =
          translateArray["date_selected_1"] +
          diffDays +
          translateArray["date_selected_2"];
        //document.getElementById("daysQuantity").value = diffDays;
        document.querySelector(".total-days").innerHTML = diffDays;*/
      }
    },
  });
});
