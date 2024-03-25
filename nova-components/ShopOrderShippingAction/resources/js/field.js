import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-shop-order-shipping-action', IndexField)
  app.component('detail-shop-order-shipping-action', DetailField)
  app.component('form-shop-order-shipping-action', FormField)
})
