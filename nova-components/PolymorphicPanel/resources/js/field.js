import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-polymorphic-panel', IndexField)
  app.component('detail-polymorphic-panel', DetailField)
  app.component('form-polymorphic-panel', FormField)
})
