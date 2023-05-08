import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-body', IndexField)
  app.component('detail-body', DetailField)
  app.component('form-body', FormField)
})
