import mitt from "mitt";



export const FILE_UPLOAD_STARTED = "FILE_UPLOAD_STARTED";
export const FILE_UPLOAD_PROGRESS = "FILE_UPLOAD_PROGRESS";
export const FILE_UPLOAD_COMPLETED = "FILE_UPLOAD_COMPLETED";
export const FILE_UPLOAD_FAILED = "FILE_UPLOAD_FAILED";

export const emitter = mitt();


