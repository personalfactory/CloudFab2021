/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller.exceptions;

import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class DtUltAggNotFoundException extends Exception {
 
  private Logger log = Logger.getLogger(DtUltAggNotFoundException.class);
 
 public DtUltAggNotFoundException(String string) {
    
   log.error(string);
  }
  
}
