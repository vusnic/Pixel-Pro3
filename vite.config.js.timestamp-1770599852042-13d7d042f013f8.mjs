// vite.config.js
import { defineConfig } from "file:///home/project/node_modules/vite/dist/node/index.js";
import laravel from "file:///home/project/node_modules/laravel-vite-plugin/dist/index.js";
import tailwindcss from "file:///home/project/node_modules/@tailwindcss/vite/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
      publicDirectory: "public",
      buildDirectory: "build",
      copyAssets: [
        "resources/assets/fonts"
      ]
    }),
    tailwindcss()
  ],
  resolve: {
    alias: {
      // Aliases para facilitar importações
      "@": "/resources/js",
      "@css": "/resources/css",
      "@assets": "/resources/assets"
    }
  },
  server: {
    cors: {
      origin: "*",
      methods: ["GET", "HEAD", "PUT", "PATCH", "POST", "DELETE"],
      credentials: true
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvaG9tZS9wcm9qZWN0XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCIvaG9tZS9wcm9qZWN0L3ZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9ob21lL3Byb2plY3Qvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHRhaWx3aW5kY3NzIGZyb20gJ0B0YWlsd2luZGNzcy92aXRlJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAuanMnXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgICAgICBwdWJsaWNEaXJlY3Rvcnk6ICdwdWJsaWMnLFxuICAgICAgICAgICAgYnVpbGREaXJlY3Rvcnk6ICdidWlsZCcsXG4gICAgICAgICAgICBjb3B5QXNzZXRzOiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9hc3NldHMvZm9udHMnXG4gICAgICAgICAgICBdLFxuICAgICAgICB9KSxcbiAgICAgICAgdGFpbHdpbmRjc3MoKSxcbiAgICBdLFxuICAgIHJlc29sdmU6IHtcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgIC8vIEFsaWFzZXMgcGFyYSBmYWNpbGl0YXIgaW1wb3J0YVx1MDBFN1x1MDBGNWVzXG4gICAgICAgICAgICAnQCc6ICcvcmVzb3VyY2VzL2pzJyxcbiAgICAgICAgICAgICdAY3NzJzogJy9yZXNvdXJjZXMvY3NzJyxcbiAgICAgICAgICAgICdAYXNzZXRzJzogJy9yZXNvdXJjZXMvYXNzZXRzJyxcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIHNlcnZlcjoge1xuICAgICAgICBjb3JzOiB7XG4gICAgICAgICAgICBvcmlnaW46ICcqJyxcbiAgICAgICAgICAgIG1ldGhvZHM6IFsnR0VUJywgJ0hFQUQnLCAnUFVUJywgJ1BBVENIJywgJ1BPU1QnLCAnREVMRVRFJ10sXG4gICAgICAgICAgICBjcmVkZW50aWFsczogdHJ1ZVxuICAgICAgICB9XG4gICAgfVxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQXlOLFNBQVMsb0JBQW9CO0FBQ3RQLE9BQU8sYUFBYTtBQUNwQixPQUFPLGlCQUFpQjtBQUV4QixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxNQUNULGlCQUFpQjtBQUFBLE1BQ2pCLGdCQUFnQjtBQUFBLE1BQ2hCLFlBQVk7QUFBQSxRQUNSO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLElBQ0QsWUFBWTtBQUFBLEVBQ2hCO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDTCxPQUFPO0FBQUE7QUFBQSxNQUVILEtBQUs7QUFBQSxNQUNMLFFBQVE7QUFBQSxNQUNSLFdBQVc7QUFBQSxJQUNmO0FBQUEsRUFDSjtBQUFBLEVBQ0EsUUFBUTtBQUFBLElBQ0osTUFBTTtBQUFBLE1BQ0YsUUFBUTtBQUFBLE1BQ1IsU0FBUyxDQUFDLE9BQU8sUUFBUSxPQUFPLFNBQVMsUUFBUSxRQUFRO0FBQUEsTUFDekQsYUFBYTtBQUFBLElBQ2pCO0FBQUEsRUFDSjtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
