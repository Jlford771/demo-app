export default {
    install(app) {
        // Import all files from components/base directory
        const components = import.meta.glob('./components/base/*.vue',{ eager: true });

        Object.entries(components).forEach(([path, definition]) => {
            // Get name of component, based on filename
            const componentName = path?.split('/').pop().replace(/\.\w+$/, '')

            // Register component on this Vue instance
            app.component(componentName, definition.default)
        })
    },
  };