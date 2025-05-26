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

    // Validate current step before proceeding
    if (!validateStep(currentStep) && direction === "next") {
      // Show error message if validation fails
      return false;
    }

    const currentElement = document.querySelector(`#formStep${currentStep}`);
    const targetElement = document.querySelector(`#formStep${targetStep}`);
    setActiveBookingStep(targetStep - 1);

    if (targetElement) {
      currentElement.classList.add("hidden");
      targetElement.classList.remove("hidden");
    }
  }

  function validateStep(step) {
    let isValid = true;
    const currentForm = document.querySelector(`#formStep${step}`);

    // Step-specific validations
    if (step === 1) {
      // Validate date selection
      const dateInput = document.querySelector('input[name="datetimes"]');
      if (!dateInput.value.trim() || dateInput.value.split("-").length !== 2) {
        dateInput.classList.add("error");
        isValid = false;

        // Create validation error message if it doesn't exist
        let errorMsg = currentForm.querySelector(".validation-error");
        if (!errorMsg) {
          errorMsg = document.createElement("div");
          errorMsg.className = "validation-error";
          errorMsg.textContent = "Please select both start and end dates";
          errorMsg.style.color = "red";
          dateInput.parentNode.appendChild(errorMsg);
        } else {
          errorMsg.style.display = "block";
        }
      } else {
        dateInput.classList.remove("error");
        const errorMsg = currentForm.querySelector(".validation-error");
        if (errorMsg) {
          errorMsg.style.display = "none";
        }
      }
    } else if (step === 2) {
      // Validate personal information fields
      const nameInput = document.querySelector("#name");
      const emailInput = document.querySelector("#email");
      const phoneInput = document.querySelector("#phone");

      // Name validation
      if (!nameInput.value.trim()) {
        nameInput.classList.add("error");
        isValid = false;
      } else {
        nameInput.classList.remove("error");
      }

      // Email validation with regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (
        !emailInput.value.trim() ||
        !emailRegex.test(emailInput.value.trim())
      ) {
        emailInput.classList.add("error");
        isValid = false;
      } else {
        emailInput.classList.remove("error");
      }

      // Phone validation - basic check for now
      if (!phoneInput.value.trim() || phoneInput.value.trim().length < 6) {
        phoneInput.classList.add("error");
        isValid = false;
      } else {
        phoneInput.classList.remove("error");
      }

      // Update personal info in sidebar if valid
      if (isValid) {
        document.querySelector(
          "#personalInfo"
        ).innerHTML = `<strong>Name:</strong> ${nameInput.value}<br>
           <strong>Email:</strong> ${emailInput.value}<br>
           <strong>Phone:</strong> ${phoneInput.value}`;
      }
    } else if (step === 3) {
      // Validate camper selection
      const camperSelected = document.querySelector(
        'input[name="camper"]:checked'
      );
      const camperError = document.querySelector("#camperError");

      if (!camperSelected) {
        isValid = false;
        if (camperError) {
          camperError.classList.remove("hidden");
        }
      } else {
        if (camperError) {
          camperError.classList.add("hidden");
        }

        // Update camper selection in sidebar
        const camperLabel = document.querySelector(
          `label[for="${camperSelected.id}"] span`
        ).textContent;
        document.querySelector(
          "#camperSelection"
        ).innerHTML = `<strong>Selected Camper:</strong> ${camperLabel}`;
      }
    }

    // General validation for all required fields
    const requiredFields = currentForm.querySelectorAll("[required]");
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        field.classList.add("error");
        isValid = false;
      } else {
        field.classList.remove("error");
      }
    });

    // Show error message if validation fails
    const errorMsg = currentForm.querySelector(".validation-error");
    if (errorMsg) {
      errorMsg.style.display = isValid ? "none" : "block";
    }

    return isValid;
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
      document.querySelector("#bookingDates").innerHTML =
        "<strong>Selected Dates:</strong> " + startDateStr + "-" + endDateStr;

      // Calculate and display duration
      const diffTime = Math.abs(date2 - date1);
      const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

      document.querySelector("#bookingDays").innerHTML =
        "<strong>Days Quantity:</strong> " + diffDays + " days";
    },
  });
});
