<template>
  <div class="carousel">
    <transition name="fade" mode="out-in">
      <img :key="currentImage" :src="images[currentImage]" alt="Image" class="carousel-image" />
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      images: [
        "{{ asset('photos/atsisiųsti.jpg') }}",  // Updated image path
        "{{ asset('photos/image1.jpg') }}",
        "{{ asset('photos/image2.jpg') }}",
        "{{ asset('photos/image3.jpg') }}",
        // Add more image paths here
      ],
      currentImage: 0,
    };
  },
  mounted() {
    this.startCarousel();
  },
  methods: {
    startCarousel() {
      setInterval(() => {
        this.currentImage = (this.currentImage + 1) % this.images.length;
      }, 3000);
    },
  },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.carousel {
  width: 100%; /* Make the carousel container responsive */
}

.carousel-image {
  width: 100%; /* Make the image fluid horizontally */
  height: auto;
}
</style>
