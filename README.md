# AsPIn - Moodle Plugin
Moodle block plugin assistant for CS1 students called AsPIn (Introductory Programming Assistant - Assistente de Programação Introdutória). Developed by undergraduate students for the University of Brasília's course Computer Science Introduction (Introdução à Ciência da Computação - ICC). This repository contains the plugin's source code and additional material developed along with this plugin.

## How to install
There's a bash file in this repository called `prepare-plugin`. Executing this file will generate a .zip file which can be uploaded to a Moodle instance: `bash prepare-plugin`.

## Computational thinking material

The folder `Computational Thinking Material` contains a .pdf file that presents concepts associated with Computational Thinking. This [video](https://youtu.be/Ehb9qh1OLeU) belongs to this material pack.

## Plugin configuration
It is important to emphasize that this code contains a series of hardcoded functionalities that are specific to our context.
Once installed, the plugin block can be added to a course page as usual. 
The block will be displayed to the student only after the configuration.
In the AsPIn configuration, the selection of the following aspects is necessary:
- A Moodle questionnaire for student profile evaluation;
- A section that will be exhibited after the student evaluation, supposed to contain any additional materials;
- Seven other questionnaires respective to the course exercises lists.
Besides that, all the lists should have a start and due date configured. The plugin will use this information to identify the list's chronological order.
