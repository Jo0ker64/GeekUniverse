import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
import { Application } from '@hotwired/stimulus';
import TogglePasswordController from './controllers/toggle_password_controller';

const application = Application.start();
application.register('toggle-password', TogglePasswordController);
