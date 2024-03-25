import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-country-icon', IndexField)
  app.component('detail-country-icon', DetailField)
  app.component('form-country-icon', FormField)
})
