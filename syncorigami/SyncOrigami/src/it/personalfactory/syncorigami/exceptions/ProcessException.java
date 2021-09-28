/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.exceptions;

import org.apache.log4j.Logger;



/**
 *
 * @author marilisa
 */
public class ProcessException extends Exception {
  
  private Logger log = Logger.getLogger(ProcessException.class);

  public ProcessException(String string) {
    log.error(string);
    
  }
  
}
