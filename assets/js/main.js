document.addEventListener("DOMContentLoaded", function () {
  // City filter functionality
  const cityFilterLinks = document.querySelectorAll(".city-filter");
  const shopContainers = document.querySelectorAll(".shop-col"); // Changed to target the container
  const selectedCityElement = document.getElementById("selectedCity");

  cityFilterLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const selectedCity = this.getAttribute("data-city");

      // Update the selected city display
      selectedCityElement.textContent =
        selectedCity === "all" ? "All Cities" : selectedCity;

      // Filter shops - single implementation
      shopContainers.forEach((container) => {
        const cardCity = container.getAttribute("data-city");

        if (selectedCity === "all" || cardCity === selectedCity) {
          container.style.display = "block";
        } else {
          container.style.display = "none";
        }
      });

      // Update URL without reloading (optional)
      const newUrl =
        selectedCity === "all"
          ? window.location.pathname
          : `${window.location.pathname}?city=${encodeURIComponent(
              selectedCity
            )}`;
      window.history.pushState({}, "", newUrl);
    });
  });

  // On page load, filter if city is in URL
  const urlParams = new URLSearchParams(window.location.search);
  const initialCity = urlParams.get("city");
  if (initialCity) {
    // Find and click the matching city link to trigger the filter
    const matchingLink = document.querySelector(
      `.city-filter[data-city="${initialCity}"]`
    );
    if (matchingLink) {
      matchingLink.click();
    }
  }
});

// Add active class to current page link
document.addEventListener("DOMContentLoaded", function () {
  const currentPage = window.location.pathname.split("/").pop();
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
    }
  });

  // Make search button functional
  document.querySelector(".search-btn").addEventListener("click", function () {
    const searchTerm = document.querySelector(".search-input").value;
    if (searchTerm.trim() !== "") {
      alert("Searching for: " + searchTerm);
      // In real implementation, this would redirect to search results
    }
  });

  // Allow search on Enter key
  document
    .querySelector(".search-input")
    .addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        document.querySelector(".search-btn").click();
      }
    });
});

// slider
let currentIndex = 0;
const slides = document.querySelectorAll(".slide");
const totalSlides = slides.length;

function updateSlider() {
  const slider = document.getElementById("slider");
  slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % totalSlides;
  updateSlider();
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateSlider();
}

// Auto-slide every 5 seconds
setInterval(nextSlide, 3000);

// Optional: Add filter count functionality
document.addEventListener("DOMContentLoaded", function () {
  const selects = document.querySelectorAll(".filter-select");
  const filterCount = document.querySelector(".filter-count");

  function updateFilterCount() {
    let count = 0;
    selects.forEach((select) => {
      if (select.value) count++;
    });
    filterCount.textContent = count;
    filterCount.style.display = count > 0 ? "inline-block" : "none";
  }

  selects.forEach((select) => {
    select.addEventListener("change", updateFilterCount);
  });

  updateFilterCount();
});

// Animation on scroll
document.addEventListener("DOMContentLoaded", function () {
  const animateElements = document.querySelectorAll(".animate-in");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("show");
        }
      });
    },
    {
      threshold: 0.1,
    }
  );

  animateElements.forEach((el) => observer.observe(el));

  // Filter functionality (placeholder - would need actual implementation)
  document
    .getElementById("applyFilters")
    .addEventListener("click", function () {
      alert(
        "Filter functionality would be implemented here with JavaScript/AJAX"
      );
      // In a real implementation, this would filter the shop cards
    });

  // Add hover effect to cards
  const cards = document.querySelectorAll(".shop-card");
  cards.forEach((card) => {
    card.addEventListener("mouseenter", () => {
      card.style.transform = "translateY(-5px)";
    });
    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0)";
    });
  });
});


