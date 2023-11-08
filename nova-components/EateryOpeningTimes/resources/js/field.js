import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-eatery-opening-times', IndexField)
  app.component('detail-eatery-opening-times', DetailField)
  app.component('form-eatery-opening-times', FormField)
})
