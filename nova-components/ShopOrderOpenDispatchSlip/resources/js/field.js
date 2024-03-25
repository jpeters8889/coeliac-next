import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-shop-order-open-dispatch-slip', IndexField)
  app.component('detail-shop-order-open-dispatch-slip', DetailField)
  app.component('form-shop-order-open-dispatch-slip', FormField)
})
