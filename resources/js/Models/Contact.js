import Model from './Model'

export default class Contact extends Model {
    // Set the resource route of the model
    resource() {
        return 'contacts'
    }
}
