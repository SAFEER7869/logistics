<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pickup Creation Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    input, select { border-radius: 10px!important; }
    .card-custom { max-width: 600px; margin: 40px auto; padding: 30px; background-color: #fff; border: 1px solid #dce3ea; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
    .section-title { color:#00326F; font-weight: bold; font-size: 1.2rem; margin-bottom: 10px; }
    .btn-submit { background-color: #c0ff8c; border: none; width: 100%; padding: 12px; font-weight: bold; color: #000; transition: all 0.2s ease-in-out; }
    .btn-submit:hover { background-color: #b8f87f; transform: scale(1.02); }
    .step { display: none; }
    .step.active { display: block; }
    .autocomplete-wrapper { position: relative; margin-bottom: 10px; }
    .suggestions-box { list-style: none; max-height: 200px; overflow-y: auto; margin: 0; padding: 0; position: absolute; top: 100%; left: 0; right: 0; background: white; z-index: 1000; }
    .suggestions-box li { padding: 10px; cursor: pointer; border-bottom: 1px solid #eee; }
    .suggestions-box li:hover { background-color: #f1f1f1; }
  </style>
</head>
<body>

<form method="POST" action="{{route('pickups.store')}}">
  @csrf
  <div class="step active" id="step1">
    <div class="mb-3">
      <div class="section-title">Route</div>
      <div class="autocomplete-wrapper">
        <input type="text" id="pickup_location" name="pickup_location" placeholder="From (ZIP or City, State)" class="form-control py-3" autocomplete="off" onblur="getDistanceAndQuote()" />
        <ul id="pickup_suggestions" class="suggestions-box"></ul>
      </div>
      <div class="autocomplete-wrapper">
        <input type="text" id="drop_location" name="drop_location" placeholder="To (ZIP or City, State)" class="form-control py-3" autocomplete="off" onblur="getDistanceAndQuote()" />
        <ul id="drop_suggestions" class="suggestions-box"></ul>
      </div>
    </div>

    <div class="mb-3">
      <div class="section-title">Shipping</div>
      <select id="pickup_date_select" class="form-select py-3 mb-2">
        <option value="" selected disabled>Pickup Date</option>
        <option value="As soon as possible">As soon as possible</option>
        <option value="Within 7 days">Within 7 days</option>
        <option value="On a particular date">On a particular date</option>
        <option value="I don't know yet">I don't know yet</option>
      </select>
      <input type="hidden" id="pickup_date" name="pickup_date" />
      <input type="date" id="specific_date" class="form-control py-3 mt-2" style="display: none;" />

     

      <select id="size_of_vehicle" name="size_of_vehicle" class="form-select py-3 mt-2" onchange="getDistanceAndQuote()">
        <option value="" selected disabled>Size of Car</option>
        <option value="Small Car">Small Car</option>
        <option value="Midsize Car">Midsize Car</option>
        <option value="Large Car">Large Car</option>
        <option value="Sports Car">Sports Car</option>
        <option value="Small SUV">Small SUV</option>
        <option value="Midsize SUV">Midsize SUV</option>
        <option value="Large SUV">Large SUV</option>
        <option value="Hypercar">Hypercar</option>
        <option value="Mini-van">Mini-van</option>
        <option value="Medium Pickup">Medium Pickup</option>
        <option value="Large Pickup">Large Pickup</option>
      </select>
    </div>

    <div id="quote_result" class="text-center mt-4 fw-bold fs-5 text-success"></div>
    <button type="button" onclick="nextStep()" class="btn btn-submit py-3">Next</button>
  </div>

  <div class="step" id="step2">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control py-3" placeholder="Enter Email" autocomplete="email" />
    </div>
    <div class="mb-3">
      <label for="contact" class="form-label">Contact</label>
      <input type="text" id="contact" name="contact" class="form-control py-3" placeholder="Enter Contact Number" autocomplete="tel" />
    </div>
    <div class="d-flex gap-2">
      <button type="button" onclick="prevStep()" class="btn btn-secondary w-50">Back</button>
      <button type="submit" class="btn btn-submit w-50">Submit</button>
    </div>
  </div>
</form>

<script>
  function showStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
    document.getElementById(`step${step}`).classList.add('active');
  }
  let currentStep = 1;
  function nextStep() { currentStep++; showStep(currentStep); }
  function prevStep() { currentStep--; showStep(currentStep); }

  function calculateQuote(miles, carYear, vehicleSize, pickupDate, pickupState, dropState, cityPopulationLowPickup, cityPopulationLowDrop) {
    let base = 0;
    if (miles <= 100) base = 300;
    else if (miles <= 200) base = 1.5 * miles;
    else if (miles <= 500) base = 1.0 * miles;
    else if (miles <= 1000) base = 0.75 * miles;
    else base = 0.6 * miles;

    if (carYear > 2020) base += 50;
    if (cityPopulationLowPickup) base += miles <= 100 ? 0 : (miles <= 1000 ? 50 : 100);
    if (cityPopulationLowDrop) base += miles <= 100 ? 0 : (miles <= 500 ? 50 : 100);
    if (pickupDate === "Within 7 days") base += 25;

    const suvTypes = ["Small SUV", "Midsize SUV", "Large SUV", "Medium Pickup", "Large Pickup"];
    if (suvTypes.includes(vehicleSize)) base += miles <= 500 ? 50 : 75;

    const snowStates = ["ND","MT","WA","OR","ID","ME","VT","MN","IL","UT","WI"];
    if (pickupDate.includes("March") || pickupDate.includes("December")) {
      if (snowStates.includes(pickupState) || snowStates.includes(dropState)) base += 200;
    }

    const extraStates = ["NY","NH","RI","CT","NM","AZ","MD","NJ"];
    if (extraStates.includes(pickupState) || extraStates.includes(dropState)) base += miles <= 500 ? 50 : 75;

    if (snowStates.includes(pickupState) || snowStates.includes(dropState)) base += 150;
    if (miles > 500) base += 50;

    return base;
  }

  function getDistanceAndQuote() {
    const size = document.getElementById("size_of_vehicle").value;
    const year = parseInt(document.getElementById("car_year").value);
    const pickup = document.getElementById("pickup_location").value;
    const drop = document.getElementById("drop_location").value;
    const pickupState = pickup.split(",").pop()?.trim().toUpperCase();
    const dropState = drop.split(",").pop()?.trim().toUpperCase();
    const pickupDate = document.getElementById("pickup_date_select").value;

    if (!pickup || !drop || !size || !year) return;

    const miles = 350; // Replace with real distance
    const quote = calculateQuote(miles, year, size, pickupDate, pickupState, dropState, true, true);
    document.getElementById("quote_result").innerText = `Estimated Price: $${quote.toFixed(2)}`;
  }

  function setupGeoapifyAutocomplete(inputId, suggestionsId) {
    const input = document.getElementById(inputId);
    const suggestionsBox = document.getElementById(suggestionsId);
    input.addEventListener("input", function () {
      const query = input.value.trim();
      if (query.length < 2) return suggestionsBox.innerHTML = "";
      const types = /^\d+$/.test(query) ? "postcode" : "city,address,postcode";
      fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&filter=countrycode:us&bias=countrycode:us&lang=en&limit=5&types=${types}&apiKey=b70212789c304f41a4194d3453f39890`)
        .then(res => res.json())
        .then(data => {
          suggestionsBox.innerHTML = "";
          data.features.forEach(feature => {
            const props = feature.properties;
            const label = [props.postcode, props.city, props.state].filter(Boolean).join(", ");
            const li = document.createElement("li");
            li.textContent = label;
            li.onclick = () => { input.value = label; suggestionsBox.innerHTML = ""; getDistanceAndQuote(); };
            suggestionsBox.appendChild(li);
          });
        });
    });
    document.addEventListener("click", e => { if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) suggestionsBox.innerHTML = ""; });
  }

  const pickupDateSelect = document.getElementById('pickup_date_select');
  const pickupDateInput = document.getElementById('pickup_date');
  const specificDateInput = document.getElementById('specific_date');
  pickupDateSelect.addEventListener('change', function () {
    const val = this.value;
    if (val === "On a particular date") {
      specificDateInput.style.display = 'block';
      specificDateInput.required = true;
      pickupDateInput.value = '';
      specificDateInput.focus();
    } else {
      specificDateInput.style.display = 'none';
      specificDateInput.required = false;
      pickupDateInput.value = val;
      getDistanceAndQuote();
    }
  });
  specificDateInput.addEventListener('change', function () {
    pickupDateInput.value = this.value;
    getDistanceAndQuote();
  });

  setupGeoapifyAutocomplete("pickup_location", "pickup_suggestions");
  setupGeoapifyAutocomplete("drop_location", "drop_suggestions");
</script>

</body>
</html>
